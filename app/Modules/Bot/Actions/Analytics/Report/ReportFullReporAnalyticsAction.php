<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportFullReportJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportFullReporAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService,
    ) {}

    public function handle(TelegraphChat $chat, string $query, int $param, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.louding'));

        ExportFullReportJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param);
    }
}
