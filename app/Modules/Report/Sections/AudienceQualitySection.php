<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\AudienceQualityContextDTO;
use App\Modules\Report\DTO\FullReportContextDTO;
use App\Modules\Report\Helper\AudienceQualityTableHelper;
use App\Modules\Report\Helper\ChartHelper;
use Illuminate\Support\Facades\Log;

class AudienceQualitySection implements PdfSectionContract
{
    public function __construct(
        protected AudienceQualityContextDTO|FullReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.audience-quality";
    }

    public function data(): array
    {
        $analytic = $this->context->audienceQualityDTO;

        $periodStart = $this->context->from;
        $periodEnd   = $this->context->to;

        $writerToMembersAll = ($analytic->writerToMembersAll ?? 0) * 100;
        $writerToShareAll = ($analytic->writerToShareAll ?? 0) * 100;

        $writerToMembersAllChart = ChartHelper::pie(
            [
                ['label' => 'Пишущие', 'value' => $writerToMembersAll],
                ['label' => 'Не пишущие', 'value' => 100 - $writerToMembersAll],
            ],
            ['value'],
            ['Пишущие','Не пишущие'],
            ['#3b82f6','#e5e7eb'],
            'Доля пишущих от всей аудитории'
        );

        $writerToShareAllChart = ChartHelper::pie(
            [
                ['label' => 'Пишущие среди активных', 'value' => $writerToShareAll],
                ['label' => 'Не пишущие среди активных', 'value' => 100 - $writerToShareAll],
            ],
            ['value'],
            ['Пишущие','Не пишущие'],
            ['#10b981','#e5e7eb'],
            'Доля пишущих среди активных'
        );

        $timeBurstRows = AudienceQualityTableHelper::build(
            $analytic->timeBurstIndexPerDay ?? []
        );

        $writerToMembersRows = AudienceQualityTableHelper::build(
            $analytic->writerToMembersPeriod ?? []
        );

        $writerToShareRows = AudienceQualityTableHelper::build(
            $analytic->writerToSharePeriod ?? []
        );

        $timeBurstChart = ChartHelper::line(
            $timeBurstRows,
            ['value'],
            ['Индекс временных всплесков'],
            ['#ef4444'],
            'Индекс временных всплесков (по дням)'
        );

        $writerToMembersChart = ChartHelper::line(
            $writerToMembersRows,
            ['value'],
            ['Доля пишущих от аудитории'],
            ['#3b82f6'],
            'Доля пишущих от всей аудитории (по дням)'
        );

        $writerToShareChart = ChartHelper::line(
            $writerToShareRows,
            ['value'],
            ['Доля пишущих среди активных'],
            ['#10b981'],
            'Доля пишущих среди активных пользователей (по дням)'
        );


        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'writerToMembersAllChart' => $writerToMembersAllChart,
            'writerToShareAllChart' => $writerToShareAllChart,

            'timeBurstIndexChart' => $timeBurstChart,
            'writerToMembersChart' => $writerToMembersChart,
            'writerShareChart' => $writerToShareChart,
        ];
    }
}
