<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportUserLeadersJob;
use App\Modules\Bot\Services\AnalyticsReportAccessService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportUserLeadersAction
{
    public function __construct(
        private readonly AnalyticsReportAccessService $reportAccessService
    ) {}

    public function handle(TelegraphChat $chat, string $query, string $param, string $lang): void
    {
        $messageId = $this->reportAccessService->startReport($chat, $lang, 'user_leaders');

        if ($messageId === null) {
            return;
        }

        ExportUserLeadersJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param);
    }
}
