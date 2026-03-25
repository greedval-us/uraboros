<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportAudienceQualityJob;
use App\Modules\Bot\Services\AnalyticsReportAccessService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportAudienceQualityAnalyticsAction
{
    public function __construct(
        private readonly AnalyticsReportAccessService $reportAccessService
    ) {}

    public function handle(TelegraphChat $chat, string $query, string $param, string $lang): void
    {
        $messageId = $this->reportAccessService->startReport($chat, $lang, 'audience_quality');

        if ($messageId === null) {
            return;
        }

        ExportAudienceQualityJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param);
    }
}
