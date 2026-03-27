<?php

namespace App\Modules\Analytics;

use App\Modules\UraborosApi\Services\UraborosApiService;
use Carbon\Carbon;
use InvalidArgumentException;

class TelegramAnalyticsService
{
    public function __construct(
        private readonly UraborosApiService $api
    ) {}

    public function fetchGroupReport(string $groupId, int $days, string $type): array
    {
        $allowedTypes = [
            'basic_metrics',
            'funnel',
            'audience_quality',
            'user_leaders',
            'full_report',
        ];

        if (!in_array($type, $allowedTypes, true)) {
            throw new InvalidArgumentException('Неверный тип отчета');
        }

        $to = Carbon::yesterday('UTC')->endOfDay();
        $from = $to->copy()->subDays($days);

        $group = $this->api->get('analytics/getGroup', ['id_group' => $groupId]);

        $payload = [
            'type' => $type,
            'group' => $group,
            'period' => [
                'from' => $from->toIso8601String(),
                'to' => $to->toIso8601String(),
                'days' => $days,
            ],
        ];

        return match ($type) {
            'basic_metrics' => $payload + [
                'analytics' => $this->getGroupAnalytics('analytics/getBaseMetrics', $groupId, $from, $to),
            ],
            'funnel' => $payload + [
                'analytics' => $this->getGroupAnalytics('analytics/getEngagementFunnel', $groupId, $from, $to),
            ],
            'audience_quality' => $payload + [
                'analytics' => $this->getGroupAnalytics('analytics/getAudienceQuality', $groupId, $from, $to),
            ],
            'user_leaders' => $payload + [
                'analytics' => $this->getGroupAnalytics('analytics/getActivityLeaders', $groupId, $from, $to),
            ],
            'full_report' => $payload + [
                'analytics' => [
                    'basic_metrics' => $this->getGroupAnalytics('analytics/getBaseMetrics', $groupId, $from, $to),
                    'funnel' => $this->getGroupAnalytics('analytics/getEngagementFunnel', $groupId, $from, $to),
                    'audience_quality' => $this->getGroupAnalytics('analytics/getAudienceQuality', $groupId, $from, $to),
                    'user_leaders' => $this->getGroupAnalytics('analytics/getActivityLeaders', $groupId, $from, $to),
                ],
            ],
        };
    }

    private function getGroupAnalytics(string $endpoint, string $groupId, Carbon $from, Carbon $to): array
    {
        return $this->api->get($endpoint, [
            'id_group' => $groupId,
            'date_from' => $from->toIso8601String(),
            'date_to' => $to->toIso8601String(),
        ]);
    }
}
