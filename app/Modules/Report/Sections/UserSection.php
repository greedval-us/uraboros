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

        $activityByGroups = UserTableHelper::buildActivityPeriod(
            $a->userAnalytic->activityByGroups,
        );

        $activityPeriodChart = ChartHelper::line(
            $activityPeriod,
            ['allGifts','allMessages','allReactions'],
            [
                'Подарки',
                'Публикация',
                'Реакция',
            ],
            ['#ef4444','#3b82f6','#10b981'],
            'Активность пользователя по дням'
        );

        $activityByGroupsChart = ChartHelper::bar(
            $activityByGroups,
            ['total','admin','users'],
            [
                'Подарки',
                'Публикация',
                'Реакция',
            ],
            ['#10b981','#ef4444','#3b82f6'],
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
