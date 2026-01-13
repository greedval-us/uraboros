<?php

namespace App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\Add;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AddChannelStepAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $text, string $lang): void
    {
        $messageId = $this->botActionService->sendText($chat, "Вы ввели: $text");

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
