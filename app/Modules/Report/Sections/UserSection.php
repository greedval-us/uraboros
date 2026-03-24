<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\UserContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\UserTableHelper;

class UserSection implements PdfSectionContract
{
    public function __construct(
        protected UserContextDTO $context,
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.user";
    }

    public function data(): array
    {
        $a = $this->context;

        $periodStart = $this->context->from;
        $periodEnd   = $this->context->to;

        $activityPeriod = UserTableHelper::buildActivityPeriod(
            $a->userAnalytic->activityPeriod,
        );

        $activityByGroups = UserTableHelper::buildActivityByGroups(
            $a->userAnalytic->activityByGroups,
        );

        $groupTitlesById = [];
        foreach (($a->userAnalytic->groups ?? []) as $group) {
            $groupId = $group['idGroup'] ?? $group['id'] ?? null;
            if ($groupId === null) {
                continue;
            }

            $groupTitlesById[(int)$groupId] = (string)($group['titleGroup'] ?? ('#' . $groupId));
        }

        foreach ($activityByGroups as &$row) {
            $groupId = (int)($row['day'] ?? 0);
            $row['groupId'] = $groupId;
            $row['day'] = $groupTitlesById[$groupId] ?? ('#' . $groupId);
        }
        unset($row);

        $activityPeriodChart = ChartHelper::line(
            $activityPeriod,
            ['allGifts','allMessages','allReactions'],
            [
                'Подарки',
                'Сообщения',
                'Реакция',
            ],
            ['#ef4444','#3b82f6','#10b981'],
            'Активность пользователя по дням'
        );

        $activityByGroupsChart = ChartHelper::bar(
            $activityByGroups,
            ['allGifts','allMessages','allReactions'],
            [
                'Подарки',
                'Сообщения',
                'Реакции',
            ],
            ['#ef4444','#3b82f6','#10b981'],
            'Активность пользователя по группам'
        );

        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'activityPeriod' => $activityPeriod,
            'activityByGroups' => $activityByGroups,

            'activityPeriodChart' => $activityPeriodChart,
            'activityByGroupsChart' => $activityByGroupsChart,
            'changedUser' => $a->changedUser ?? [],

            'user' => $a->user ?? [],
            'groups' => $a->userAnalytic->groups ?? [],

            'allGifts' => $a->userAnalytic->allActivity['allGifts'] ?? 0,
            'allMessages' => $a->userAnalytic->allActivity['allMessages'] ?? 0,
            'allReactions' => $a->userAnalytic->allActivity['allReactions'] ?? 0,
        ];
    }
}
