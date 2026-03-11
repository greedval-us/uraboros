<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\UserLeadersContextDTO;
use App\Modules\Report\Helper\ChartHelper;

class UserLeadersSection implements PdfSectionContract
{
    public function __construct(
        protected UserLeadersContextDTO $userLeaders,
        protected string $lang = 'ru'
    ) {}

    public function view(): string
    {
        return "pdf.{$this->lang}.sections.user-leaders";
    }

public function data(): array
{
    $top10ByMessage = $this->userLeaders->analytic->top10ByMessage;
    $top10ByReaction = $this->userLeaders->analytic->top10ByReaction;
    $top10ByTotal = $this->userLeaders->analytic->top10ByMessageAndReaction;

    // Преобразуем массив в формат [['label' => 'ID', 'value' => count], ...]
    $formatTop10 = fn(array $data): array => array_map(
        fn($id, $count) => ['label' => (string)$id, 'value' => $count],
        array_keys($data),
        array_values($data)
    );

    $messageChart = ChartHelper::pie(
        $formatTop10($top10ByMessage),
        ['value'],
        array_column($formatTop10($top10ByMessage), 'label'),
        ['#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6','#3b82f6'],
        'Топ-10 пользователей по сообщениям'
    );

    $reactionChart = ChartHelper::pie(
        $formatTop10($top10ByReaction),
        ['value'],
        array_column($formatTop10($top10ByReaction), 'label'),
        ['#10b981','#10b981','#10b981','#10b981','#10b981','#10b981','#10b981','#10b981','#10b981','#10b981'],
        'Топ-10 пользователей по реакциям'
    );

    $totalChart = ChartHelper::pie(
        $formatTop10($top10ByTotal),
        ['value'],
        array_column($formatTop10($top10ByTotal), 'label'),
        ['#ef4444','#ef4444','#ef4444','#ef4444','#ef4444','#ef4444','#ef4444','#ef4444','#ef4444','#ef4444'],
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
