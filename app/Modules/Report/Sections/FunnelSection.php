<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\FunnelContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\PeriodTableHelper;

class FunnelSection implements PdfSectionContract
{
    public function __construct(
        protected FunnelContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.funnel";
    }

    public function data(): array
    {
        $a = $this->context->analytic;

        $periodStart = $this->context->from;
        $periodEnd   = $this->context->to;

        $funnelByDay = PeriodTableHelper::build(
            $a->viewRatePeriod,
            [
                'reactionRate' => $a->reactionRatePeriod,
                'commentRate'  => $a->commentRatePeriod,
                'erView'       => $a->ERviewPeriod,
            ]
        );

        $viewRateChart = ChartHelper::line(
            $funnelByDay,
            ['total'],
            ['ViewRate'],
            ['#3b82f6'],
            'Просмотр публикаций (ViewRate)'
        );

        $reactionRateChart = ChartHelper::line(
            $funnelByDay,
            ['reactionRate'],
            ['ReactionRate'],
            ['#3b82f6'],
            'Доля реакций (ReactionRate)'
        );

        $commentRateChart = ChartHelper::line(
            $funnelByDay,
            ['commentRate'],
            ['CommentRate'],
            ['#3b82f6'],
            'Доля комментариев (CommentRate)'
        );

        $erViewChart = ChartHelper::line(
            $funnelByDay,
            ['erView'],
            ['ERview'],
            ['#3b82f6'],
            'Вовлеченность от просмотров (ERview)'
        );

        return [

            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'avgViewRate' => round($a->allViewRate ?? 0, 4),
            'avgReactionRate' => round($a->allReactionRate ?? 0, 4),
            'avgCommentRate' => round($a->allCommentRate ?? 0, 4),
            'avgERview' => round($a->allERview ?? 0, 4),

            'funnelByDay' => $funnelByDay,

            'viewRateChart' => $viewRateChart,
            'reactionRateChart' => $reactionRateChart,
            'commentRateChart' => $commentRateChart,
            'erViewChart' => $erViewChart,
        ];
    }
}
