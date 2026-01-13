<?php

namespace App\Modules\Bot\Actions\Settings;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenLanguageSettingsAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->botActionService->sendInline(CommandKey::Language->value, $lang, $chat);

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
