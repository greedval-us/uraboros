<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\Helper\AudienceQualityTableHelper;
use App\Modules\Report\Helper\ChartHelper;
use Illuminate\Support\Facades\Log;

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
        // Общие показатели
        $writerToMembersAll = ($this->context->writerToMembersAll ?? 0) * 100;
        $writerToShareAll = ($this->context->writerToShareAll ?? 0) * 100;

        // Круговые графики общей структуры
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

        // Подготовка данных для графиков по дням
        $timeBurstRows = AudienceQualityTableHelper::build(
            $this->context->timeBurstIndexPeriod ?? []
        );

        $writerToMembersRows = AudienceQualityTableHelper::buildPercent(
            $this->context->writerToMembersPeriod ?? []
        );

        $writerToShareRows = AudienceQualityTableHelper::buildPercent(
            $this->context->writerToSharePeriod ?? []
        );

        // Логирование для проверки
        Log::info('timeBurstRows', $timeBurstRows);
        Log::info('writerToMembersRows', $writerToMembersRows);
        Log::info('writerToShareRows', $writerToShareRows);

        // Линейные графики
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

        // Возвращаем данные для графиков и таблиц
        return [
            // Круговые графики
            'writerToMembersAllChart' => $writerToMembersAllChart,
            'writerToShareAllChart' => $writerToShareAllChart,

            // Линейные графики
            'timeBurstIndexChart' => $timeBurstChart,
            'writerToMembersChart' => $writerToMembersChart,
            'writerShareChart' => $writerToShareChart,

            // Данные для таблиц в Blade
            'timeBurstIndexByDay' => $timeBurstRows,
            'writerToMembersByDay' => $writerToMembersRows,
            'writerShareByDay' => $writerToShareRows,

            // Общие числовые показатели
            'writerToMembers' => round($writerToMembersAll, 4),
            'writerShare' => round($writerToShareAll, 4),
        ];
    }
}
