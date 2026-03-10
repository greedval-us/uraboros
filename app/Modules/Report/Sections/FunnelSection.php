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
