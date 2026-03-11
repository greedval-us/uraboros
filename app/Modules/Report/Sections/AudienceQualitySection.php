<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\AudienceQualityContextDTO;
use App\Modules\Report\Helper\AudienceQualityTableHelper;
use App\Modules\Report\Helper\ChartHelper;
use Illuminate\Support\Facades\Log;

class AudienceQualitySection implements PdfSectionContract
{
    public function __construct(
        protected AudienceQualityContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.audience-quality";
    }

    public function data(): array
    {
        $writerToMembersAll = ($this->context->analytic->writerToMembersAll ?? 0) * 100;
        $writerToShareAll = ($this->context->analytic->writerToShareAll ?? 0) * 100;

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
            $this->context->analytic->timeBurstIndexPeriod ?? []
        );

        $writerToMembersRows = AudienceQualityTableHelper::buildPercent(
            $this->context->analytic->writerToMembersPeriod ?? []
        );

        $writerToShareRows = AudienceQualityTableHelper::buildPercent(
            $this->context->analytic->writerToSharePeriod ?? []
        );
        Log::info($timeBurstRows);
        Log::info( $writerToMembersRows);
        Log::info($writerToShareRows);
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
            'writerToMembersAllChart' => $writerToMembersAllChart,
            'writerToShareAllChart' => $writerToShareAllChart,

            'timeBurstIndexChart' => $timeBurstChart,
            'writerToMembersChart' => $writerToMembersChart,
            'writerShareChart' => $writerToShareChart,

            'timeBurstIndexByDay' => $timeBurstRows,
            'writerToMembersByDay' => $writerToMembersRows,
            'writerShareByDay' => $writerToShareRows,

            'writerToMembers' => round($writerToMembersAll, 4),
            'writerShare' => round($writerToShareAll, 4),
        ];
    }
}
