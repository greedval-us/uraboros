<?php

namespace App\Modules\Bot\Actions\Analytics\Run;

use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Job\Analytics\ChannelJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class RunChannelAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $text, string $lang): void
    {
        $this->storageService->set($chat, StorageKey::MENU->value, '');

        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.louding'));

        ChannelJob::dispatch($lang, $chat, $chat->chat_id, $messageId, $text)->onQueue('run-analytics');
    }
}
