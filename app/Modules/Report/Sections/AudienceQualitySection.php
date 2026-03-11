<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\Helper\ChartHelper;

class AudienceQualitySection implements PdfSectionContract
{
    public function __construct(
        protected object $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.audience-quality";
    }

    public function data(): array
    {
        $writerToMembersAll = ($this->context->writerToMembersAll ?? 0) * 100;
        $writerToShareAll = ($this->context->writerToShareAll ?? 0) * 100;

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

        $days = [];
        $timeBurst = [];
        $writerToMembers = [];
        $writerToShare = [];

        foreach (($this->context->timeBurstIndexPeriod ?? []) as $i => $row) {

            $day = array_key_first($row);

            $days[] = $day;

            $timeBurst[] = $row[$day] ?? 0;

            $writerToMembers[] =
                (($this->context->writerToMembersPeriod[$i][$day] ?? 0) * 100);

            $writerToShare[] =
                (($this->context->writerToSharePeriod[$i][$day] ?? 0) * 100);
        }

        $timeBurstChart = ChartHelper::line(
            array_map(fn($i) => ['day' => $days[$i], 'value' => $timeBurst[$i]], range(0, count($days)-1)),
            ['value'],
            ['Индекс временных всплесков'],
            ['#ef4444'],
            'Индекс временных всплесков (по дням)'
        );

        $writerToMembersChart = ChartHelper::line(
            array_map(fn($i) => ['day' => $days[$i], 'value' => $writerToMembers[$i]], range(0, count($days)-1)),
            ['value'],
            ['Доля пишущих от аудитории'],
            ['#3b82f6'],
            'Доля пишущих от всей аудитории (по дням)'
        );

        $writerToShareChart = ChartHelper::line(
            array_map(fn($i) => ['day' => $days[$i], 'value' => $writerToShare[$i]], range(0, count($days)-1)),
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
        ];
    }
}
