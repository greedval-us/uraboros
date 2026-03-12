<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\FullReportContextDTO;
use App\Modules\Report\DTO\FunnelContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\FunnelTableHelper;

class FunnelSection implements PdfSectionContract
{
    public function __construct(
        protected FunnelContextDTO|FullReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.funnel";
    }

    public function data(): array
{
    $a = $this->context->funnelDTO;

    $periodStart = $this->context->from;
    $periodEnd   = $this->context->to;

    $funnelByDay = FunnelTableHelper::build(
        $a->ERperDay ?? []
    );

    $viewRatePeriod = FunnelTableHelper::buildRate($a->viewRatePeriod ?? []);
    $reactionRatePeriod = FunnelTableHelper::buildRate($a->reactionRatePeriod ?? []);
    $commentRatePeriod = FunnelTableHelper::buildRate($a->commentRatePeriod ?? []);
    $ERviewPeriod = FunnelTableHelper::buildRate($a->ERviewPeriod ?? []);

    $funnelChart = ChartHelper::bar(
        $funnelByDay,
        ['viewRate','reactionRate','commentRate','erView'],
        [
            'Просмотр публикации',
            'Реакция на публикацию',
            'Участие в обсуждении',
            'Охват просмотров'
        ],
        [
            '#3b82f6',
            '#10b981',
            '#f59e0b',
            '#ef4444'
        ],
        'Воронка вовлеченности'
    );


    $viewRateChart = ChartHelper::line(
        $a->viewRatePeriod ?? [],
            ['value'],
            ['Просмотры'],
            ['#3b82f6'],
            'Просмотр публикаций'
    );

    $reactionRateChart = ChartHelper::line(
        $a->reactionRatePeriod ?? [],
            ['value'],
            ['Реакции'],
            ['#3b82f6'],
            'Доля реакций '
    );

    $commentRateChart = ChartHelper::line(
        $a->commentRatePeriod ?? [],
            ['value'],
            ['Коментарии'],
            ['#3b82f6'],
            'Доля комментариев'
    );

    $erViewChart = ChartHelper::line(
        $a->ERviewPeriod ?? [],
            ['value'],
            ['Пользователи'],
            ['#3b82f6'],
            'Вовлеченность от просмотров'
    );

    return [
        'periodStart' => $periodStart,
        'periodEnd' => $periodEnd,

        'avgViewRate' => round($a->allViewRate ?? 0, 4) * 100,
        'avgReactionRate' => round($a->allReactionRate ?? 0, 4) * 100,
        'avgCommentRate' => round($a->allCommentRate ?? 0, 4) * 100,
        'avgERview' => round($a->allERview ?? 0, 4) * 100,

        'funnelChart' => $funnelChart,

        'viewRatePeriod' => $viewRatePeriod,
        'reactionRatePeriod' => $reactionRatePeriod,
        'commentRatePeriod' => $commentRatePeriod,
        'ERviewPeriod' => $ERviewPeriod,

        'viewRateChart' => $viewRateChart,
        'reactionRateChart' => $reactionRateChart,
        'commentRateChart' => $commentRateChart,
        'erViewChart' => $erViewChart,
    ];
}
}
