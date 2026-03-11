<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\FunnelContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\FunnelTableHelper;
use App\Modules\Report\Helper\PeriodTableHelper;
use Illuminate\Support\Facades\Log;

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

        $funnelByDay = FunnelTableHelper::build(
            $a->ERperDay ?? []
        );

        Log::info($funnelByDay);

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


        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'avgViewRate' => round($a->allViewRate ?? 0, 4),
            'avgReactionRate' => round($a->allReactionRate ?? 0, 4),
            'avgCommentRate' => round($a->allCommentRate ?? 0, 4),
            'avgERview' => round($a->allERview ?? 0, 4),

            'funnelByDay' => $funnelChart,

            'viewRateChart' => $funnelChart,
            'reactionRateChart' => $funnelChart,
            'commentRateChart' => $funnelChart,
            'erViewChart' => $funnelChart,
        ];
    }
}
