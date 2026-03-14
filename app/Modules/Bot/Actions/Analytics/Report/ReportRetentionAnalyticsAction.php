<?php

namespace App\Modules\Bot\Actions\Analytics\Report;

use App\Modules\Bot\Job\Analytics\Report\ExportRetentionJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportRetentionAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $query, string $param, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.louding'));

        ExportRetentionJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $query, $param)->onQueue('report-analytics');
    }
}
