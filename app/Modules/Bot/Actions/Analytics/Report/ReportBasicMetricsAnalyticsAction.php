<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportBasicMetricsJob;
use App\Modules\Bot\Services\AnalyticsReportAccessService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportBasicMetricsAnalyticsAction
{
    public function __construct(
        private readonly AnalyticsReportAccessService $reportAccessService
    ) {}

    public function handle(TelegraphChat $chat, string $query, int $param, string $lang): void
    {
        $messageId = $this->reportAccessService->startReport($chat, $lang, 'basic_metrics');

        if ($messageId === null) {
            return;
        }

        ExportBasicMetricsJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param);
    }
}
