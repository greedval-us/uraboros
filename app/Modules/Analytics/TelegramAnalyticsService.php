<?php

namespace App\Modules\Analytics;

use App\Modules\UraborosApi\Contracts\UraborosApiInterface;
use Carbon\Carbon;
use InvalidArgumentException;

class TelegramAnalyticsService
{
    public function __construct(
        private readonly UraborosApiInterface $api
    ) {}

    public function getChannelAnalytics(string $input, int $days): array
    {
        $groupFilter = $this->resolveGroupFilter($input);

        if ($groupFilter === null) {
            throw new InvalidArgumentException('Неверный формат канала. Используйте @username, ссылку t.me/... или id группы.');
        }

        $group = $this->api->get('analytics/getGroup', $groupFilter);

        if (empty($group)) {
            throw new InvalidArgumentException('Канал не найден в аналитической базе.');
        }

        $idGroup = (string) ($group['idGroup'] ?? '');

        if ($idGroup === '') {
            throw new InvalidArgumentException('Для канала не найден id_group, аналитика недоступна.');
        }

        $to = Carbon::yesterday('UTC')->endOfDay();
        $from = $to->copy()->subDays($days);

        $baseMetrics = $this->api->get('analytics/getBaseMetrics', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $audienceQuality = $this->api->get('analytics/getAudienceQuality', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        return [
            'group' => $this->normalizeGroup($group),
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'basicMetrics' => $this->normalizeBasicMetrics($baseMetrics),
            'audienceQuality' => $this->normalizeAudienceQuality($audienceQuality),
        ];
    }

    private function resolveGroupFilter(string $input): ?array
    {
        $input = trim($input);

        if ($input === '') {
            return null;
        }

        if (preg_match('/^-\d+$/', $input) || preg_match('/^\d+$/', $input)) {
            return ['id_group' => $input];
        }

        if (preg_match('/^@(?<username>[a-zA-Z0-9_]{3,})$/', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        if (preg_match('/^(?<username>[a-zA-Z0-9_]{3,})$/', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        if (preg_match('/(?:https:\/\/)?t\.me\/{1,2}(?<username>[a-zA-Z0-9_]{3,})\/?$/i', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        return null;
    }

    private function normalizeGroup(array $group): array
    {
        return [
            'id' => $group['id'] ?? null,
            'idGroup' => $group['idGroup'] ?? null,
            'titleGroup' => $group['titleGroup'] ?? null,
            'findGroup' => $group['findGroup'] ?? null,
            'participantsCount' => $group['participantsCount'] ?? null,
            'lastUpdate' => $group['lastUpdate'] ?? null,
        ];
    }

    private function normalizeBasicMetrics(array $basicMetrics): array
    {
        return [
            'allPublications' => $basicMetrics['allPublications'] ?? null,
            'allActiveUsers' => $basicMetrics['allActiveUsers'] ?? null,
            'engagementRate' => isset($basicMetrics['engagementRate']) ? (float) $basicMetrics['engagementRate'] : null,
            'commentsPerPost' => isset($basicMetrics['commentsPerPost']) ? (float) $basicMetrics['commentsPerPost'] : null,
            'reactionsPerPost' => isset($basicMetrics['reactionsPerPost']) ? (float) $basicMetrics['reactionsPerPost'] : null,
            'activeUsersPerComments' => $basicMetrics['activeUsersPerComments'] ?? null,
            'activeUsersPerReactions' => $basicMetrics['activeUsersPerReactions'] ?? null,
            'activeUsersPerCommentsAndReactions' => $basicMetrics['activeUsersPerCommentsAndReactions'] ?? null,
            'allPublicationsPeriod' => $this->mapPeriod($basicMetrics['allPublicationsPeriod'] ?? []),
            'allActiveUsersPeriod' => $this->mapPeriod($basicMetrics['allActiveUsersPeriod'] ?? []),
            'engagementRatePeriod' => $this->mapPeriod($basicMetrics['engagementRatePeriod'] ?? []),
        ];
    }

    private function normalizeAudienceQuality(array $audienceQuality): array
    {
        return [
            'writerToMembersAll' => isset($audienceQuality['writerToMembersAll']) ? (float) $audienceQuality['writerToMembersAll'] : null,
            'writerToShareAll' => isset($audienceQuality['writerToShareAll']) ? (float) $audienceQuality['writerToShareAll'] : null,
            'writerToMembersPeriod' => $this->mapPeriod($audienceQuality['writerToMembersPeriod'] ?? []),
            'writerToSharePeriod' => $this->mapPeriod($audienceQuality['writerToSharePeriod'] ?? []),
            'timeBurstIndexPeriod' => $this->mapPeriod($audienceQuality['timeBurstIndexPeriod'] ?? []),
        ];
    }

    private function mapPeriod(array $period): array
    {
        $result = [];

        foreach ($period as $item) {
            if (!is_array($item)) {
                continue;
            }

            foreach ($item as $date => $value) {
                if ($date === null) {
                    continue;
                }

                $result[(string) $date] = $value;
            }
        }

        ksort($result);

        return $result;
    }
}
