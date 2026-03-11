<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\FullReportContextDTO;
use App\Modules\Report\DTO\UserLeadersContextDTO;
use App\Modules\Report\Helper\ChartHelper;

class UserLeadersSection implements PdfSectionContract
{
    public function __construct(
        protected UserLeadersContextDTO|FullReportContextDTO $userLeaders,
        protected string $lang = 'ru'
    ) {}

    public function view(): string
    {
        return "pdf.{$this->lang}.sections.user-leaders";
    }

    public function data(): array
    {
        $top10ByMessage = $this->userLeaders->userLeadersDTO->top10ByMessage;
        $top10ByReaction = $this->userLeaders->userLeadersDTO->top10ByReaction;
        $top10ByTotal = $this->userLeaders->userLeadersDTO->top10ByMessageAndReaction;

        $formatTop10 = fn(array $data): array => array_map(
            fn($id, $count) => ['label' => (string)$id, 'value' => $count],
            array_keys($data),
            array_values($data)
        );

        $colors = [
            '#3b82f6','#10b981','#ef4444','#f59e0b','#8b5cf6',
            '#06b6d4','#e11d48','#facc15','#22c55e','#0ea5e9'
        ];

        $messageChart = ChartHelper::pie(
            $formatTop10($top10ByMessage),
            ['value'],
            array_column($formatTop10($top10ByMessage), 'label'),
            $colors,
            'Топ-10 пользователей по сообщениям'
        );

        $reactionChart = ChartHelper::pie(
            $formatTop10($top10ByReaction),
            ['value'],
            array_column($formatTop10($top10ByReaction), 'label'),
            $colors,
            'Топ-10 пользователей по реакциям'
        );

        $totalChart = ChartHelper::pie(
            $formatTop10($top10ByTotal),
            ['value'],
            array_column($formatTop10($top10ByTotal), 'label'),
            $colors,
            'Топ-10 пользователей по совокупной активности'
        );

        return [
            'top10ByMessage' => $top10ByMessage,
            'top10ByReaction' => $top10ByReaction,
            'top10ByTotal' => $top10ByTotal,
            'messageChart' => $messageChart,
            'reactionChart' => $reactionChart,
            'totalChart' => $totalChart,
        ];
    }
}
