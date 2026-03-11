<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\FunnelContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use Carbon\Carbon;

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

        $funnelByDay = [];

        foreach ($a->ERperDay ?? [] as $row) {

            $date = array_key_first($row);
            $data = $row[$date];

            $funnelByDay[] = [
                'day' => Carbon::parse($date)->format('d.m'),

                'total' => round(($data['viewRate'] ?? 0) * 100, 2),
                'reactionRate' => round(($data['reactionRate'] ?? 0) * 100, 2),
                'commentRate' => round(($data['commentRate'] ?? 0) * 100, 2),
                'erView' => round(($data['ERview'] ?? 0) * 100, 2),
            ];
        }

        $viewRateChart = ChartHelper::bar(
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
            ['#f59e0b'],
            'Доля реакций (ReactionRate)'
        );

        $commentRateChart = ChartHelper::line(
            $funnelByDay,
            ['commentRate'],
            ['CommentRate'],
            ['#ef4444'],
            'Доля комментариев (CommentRate)'
        );

        $erViewChart = ChartHelper::line(
            $funnelByDay,
            ['erView'],
            ['ERview'],
            ['#10b981'],
            'Вовлеченность от просмотров (ERview)'
        );

        return [

            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'avgViewRate' => round(($a->allViewRate ?? 0) * 100, 2),
            'avgReactionRate' => round(($a->allReactionRate ?? 0) * 100, 2),
            'avgCommentRate' => round(($a->allCommentRate ?? 0) * 100, 2),
            'avgERview' => round(($a->allERview ?? 0) * 100, 2),

            'funnelByDay' => $funnelByDay,

            'viewRateChart' => $viewRateChart,
            'reactionRateChart' => $reactionRateChart,
            'commentRateChart' => $commentRateChart,
            'erViewChart' => $erViewChart,
        ];
    }
}
