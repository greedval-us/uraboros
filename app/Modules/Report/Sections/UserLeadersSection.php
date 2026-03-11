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

        // Генерация графиков
        $messageChart = ChartHelper::pie(
            [$top10ByMessage],
            ['total'],
            ['Количество сообщений'],
            ['#3b82f6'],
            'Топ-10 пользователей по сообщениям'
        );

        $reactionChart = ChartHelper::pie(
            [$top10ByReaction],
            ['total'],
            ['Количество реакций'],
            ['#10b981'],
            'Топ-10 пользователей по реакциям'
        );

        $totalChart = ChartHelper::pie(
            [$top10ByTotal],
            ['total'],
            ['Совокупная активность'],
            ['#ef4444'],
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
