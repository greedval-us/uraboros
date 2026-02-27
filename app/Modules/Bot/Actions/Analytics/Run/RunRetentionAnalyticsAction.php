<?php

namespace App\Modules\Bot\Actions\Analytics\Run;

use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Job\Analytics\RetentionJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class RunRetentionAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $this->storageService->set($chat, StorageKey::MENU->value, '');

        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'search.channel.louding'));

        RetentionJob::dispatch($lang, $chat->chat_id, $messageId);
    }
}
