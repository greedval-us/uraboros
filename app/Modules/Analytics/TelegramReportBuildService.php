<?php

namespace App\Modules\Analytics;

use App\Modules\Bot\DTO\AudienceQualityDTO;
use App\Modules\Bot\DTO\BasicMetriicsDTO;
use App\Modules\Bot\DTO\ChangedUserDTO;
use App\Modules\Bot\DTO\FunnelDTO;
use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\DTO\UserAnalyticsDTO;
use App\Modules\Bot\DTO\UserDTO;
use App\Modules\Bot\DTO\UserLeadersDTO;
use App\Modules\Report\DTO\AudienceQualityContextDTO;
use App\Modules\Report\DTO\BasicMetricsContextDTO;
use App\Modules\Report\DTO\FullReportContextDTO;
use App\Modules\Report\DTO\FunnelContextDTO;
use App\Modules\Report\DTO\UserContextDTO;
use App\Modules\Report\DTO\UserLeadersContextDTO;
use App\Modules\Report\Enums\ReportType;
use App\Modules\Report\Pdf\PdfReportService;
use App\Modules\Report\Sections\AudienceQualitySection;
use App\Modules\Report\Sections\BasicMetricsSection;
use App\Modules\Report\Sections\FunnelSection;
use App\Modules\Report\Sections\UserLeadersSection;
use App\Modules\Report\Sections\UserSection;
use App\Modules\UraborosApi\Contracts\UraborosApiInterface;
use Carbon\Carbon;
use InvalidArgumentException;

class TelegramReportBuildService
{
    public function __construct(
        private readonly UraborosApiInterface $api,
        private readonly PdfReportService $pdfReportService,
    ) {}

    public function build(string $type, string $target, int $days, string $lang = 'ru'): array
    {
        $to = Carbon::yesterday('UTC')->endOfDay();
        $from = $to->copy()->subDays($days);

        return match ($type) {
            'basic' => $this->buildBasic($target, $days, $lang, $from, $to),
            'audience' => $this->buildAudience($target, $days, $lang, $from, $to),
            'funnel' => $this->buildFunnel($target, $days, $lang, $from, $to),
            'user_leaders' => $this->buildUserLeaders($target, $days, $lang, $from, $to),
            'full_report' => $this->buildFullReport($target, $days, $lang, $from, $to),
            'user' => $this->buildUser($target, $days, $lang, $from, $to),
            default => throw new InvalidArgumentException('Неизвестный тип отчета.'),
        };
    }

    public function renderPdf(array $build): string
    {
        return $this->pdfReportService
            ->generate($build['context'], $build['reportType'])
            ->output();
    }

    private function buildBasic(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        [$groupDto, $groupRaw, $idGroup] = $this->resolveGroup($target);

        $raw = $this->api->get('analytics/getBaseMetrics', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $context = new BasicMetricsContextDTO(
            group: $groupDto,
            basicMetriicsDTO: BasicMetriicsDTO::fromApi($raw),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::BASIC,
            'context' => $context,
            'entity' => [
                'kind' => 'group',
                'id' => $idGroup,
                'title' => $groupRaw['titleGroup'] ?? $groupRaw['findGroup'] ?? null,
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'basic' => (new BasicMetricsSection($context))->data(),
            ],
        ];
    }

    private function buildAudience(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        [$groupDto, $groupRaw, $idGroup] = $this->resolveGroup($target);

        $raw = $this->api->get('analytics/getAudienceQuality', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $context = new AudienceQualityContextDTO(
            group: $groupDto,
            audienceQualityDTO: AudienceQualityDTO::fromApi($raw),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::AUDIENCE,
            'context' => $context,
            'entity' => [
                'kind' => 'group',
                'id' => $idGroup,
                'title' => $groupRaw['titleGroup'] ?? $groupRaw['findGroup'] ?? null,
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'audience' => (new AudienceQualitySection($context))->data(),
            ],
        ];
    }

    private function buildFunnel(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        [$groupDto, $groupRaw, $idGroup] = $this->resolveGroup($target);

        $raw = $this->api->get('analytics/getEngagementFunnel', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $context = new FunnelContextDTO(
            group: $groupDto,
            funnelDTO: FunnelDTO::fromApi($raw),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::FUNNEL,
            'context' => $context,
            'entity' => [
                'kind' => 'group',
                'id' => $idGroup,
                'title' => $groupRaw['titleGroup'] ?? $groupRaw['findGroup'] ?? null,
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'funnel' => (new FunnelSection($context))->data(),
            ],
        ];
    }

    private function buildUserLeaders(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        [$groupDto, $groupRaw, $idGroup] = $this->resolveGroup($target);

        $raw = $this->api->get('analytics/getActivityLeaders', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $context = new UserLeadersContextDTO(
            group: $groupDto,
            userLeadersDTO: UserLeadersDTO::fromApi($raw),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::USERLEADERS,
            'context' => $context,
            'entity' => [
                'kind' => 'group',
                'id' => $idGroup,
                'title' => $groupRaw['titleGroup'] ?? $groupRaw['findGroup'] ?? null,
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'user_leaders' => (new UserLeadersSection($context))->data(),
            ],
        ];
    }

    private function buildFullReport(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        [$groupDto, $groupRaw, $idGroup] = $this->resolveGroup($target);

        $base = $this->api->get('analytics/getBaseMetrics', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $audience = $this->api->get('analytics/getAudienceQuality', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $funnel = $this->api->get('analytics/getEngagementFunnel', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $leaders = $this->api->get('analytics/getActivityLeaders', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_group' => $idGroup,
        ]);

        $context = new FullReportContextDTO(
            group: $groupDto,
            funnelDTO: FunnelDTO::fromApi($funnel),
            audienceQualityDTO: AudienceQualityDTO::fromApi($audience),
            basicMetriicsDTO: BasicMetriicsDTO::fromApi($base),
            userLeadersDTO: UserLeadersDTO::fromApi($leaders),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::FULLREPORT,
            'context' => $context,
            'entity' => [
                'kind' => 'group',
                'id' => $idGroup,
                'title' => $groupRaw['titleGroup'] ?? $groupRaw['findGroup'] ?? null,
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'basic' => (new BasicMetricsSection($context))->data(),
                'audience' => (new AudienceQualitySection($context))->data(),
                'funnel' => (new FunnelSection($context))->data(),
                'user_leaders' => (new UserLeadersSection($context))->data(),
            ],
        ];
    }

    private function buildUser(string $target, int $days, string $lang, Carbon $from, Carbon $to): array
    {
        if (!preg_match('/^\d+$/', trim($target))) {
            throw new InvalidArgumentException('Для user-отчета нужен числовой id_user.');
        }

        $userId = trim($target);

        $userRaw = $this->api->get('analytics/getUser', ['id_user' => $userId]);
        $analyticRaw = $this->api->get('analytics/getBaseAnalyticUser', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_user' => $userId,
        ]);
        $changedRaw = $this->api->get('analytics/getUserChanged', [
            'from' => $from->toIso8601String(),
            'to' => $to->toIso8601String(),
            'id_user' => $userId,
        ]);

        $context = new UserContextDTO(
            user: UserDTO::fromApi($userRaw),
            userAnalytic: UserAnalyticsDTO::fromApi($analyticRaw),
            changedUser: ChangedUserDTO::fromApiList($changedRaw),
            lang: $lang,
            days: $days,
            to: $to->toDateString(),
            from: $from->toDateString(),
        );

        return [
            'reportType' => ReportType::USERREPORT,
            'context' => $context,
            'entity' => [
                'kind' => 'user',
                'id' => $userId,
                'title' => $context->user->username ?? $context->user->firstName ?? ('user_' . $userId),
            ],
            'period' => [
                'from' => $from->toDateString(),
                'to' => $to->toDateString(),
                'days' => $days,
            ],
            'viewData' => [
                'user' => (new UserSection($context))->data(),
            ],
        ];
    }

    private function resolveGroup(string $input): array
    {
        $input = trim($input);
        $filter = $this->resolveGroupFilter($input);

        if ($filter === null) {
            throw new InvalidArgumentException('Неверный формат канала.');
        }

        $groupRaw = $this->api->get('analytics/getGroup', $filter);

        if (empty($groupRaw)) {
            throw new InvalidArgumentException('Канал не найден в аналитической базе.');
        }

        $idGroup = (string) ($groupRaw['idGroup'] ?? '');

        if ($idGroup === '') {
            throw new InvalidArgumentException('Для канала не найден id_group.');
        }

        return [GroupDTO::fromApi($groupRaw), $groupRaw, $idGroup];
    }

    private function resolveGroupFilter(string $input): ?array
    {
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
}
