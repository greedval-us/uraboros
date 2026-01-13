<?php

namespace App\Modules\Bot\Actions\Monitoring;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenChannelsMonitoringAction
{
    public function __construct(
        private BotActionService $bot,
        private StorageService $storage
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendInline(CommandKey::ChannelsM->value, $lang, $chat);

        $this->storage->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
