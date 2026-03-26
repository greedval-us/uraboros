<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportRetentionJob;
use App\Modules\Bot\Services\AnalyticsReportAccessService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportRetentionAnalyticsAction
{
    public function __construct(
        private readonly AnalyticsReportAccessService $reportAccessService
    ) {}

    public function handle(TelegraphChat $chat, string $query, string $param, string $lang): void
    {
        $messageId = $this->reportAccessService->startReport($chat, $lang, 'retention');

        if ($messageId === null) {
            return;
        }

        ExportRetentionJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param);
    }
}
