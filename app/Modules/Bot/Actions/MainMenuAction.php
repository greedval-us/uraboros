<?php

namespace App\Modules\Bot\Actions;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class MainMenuAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $action, string $lang): void
    {
        $this->storageService->set($chat, StorageKey::MENU->value, '');
        $messageId = $this->botActionService->sendInline($action, $lang, $chat);
        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);

    }
}
