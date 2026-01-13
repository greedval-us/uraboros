<?php

namespace App\Modules\Bot\Actions\Language;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class SelectLanguageAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService
    ) {}

    public function handle(TelegraphChat $chat, string $newLang): void
    {
        $this->storageService->set($chat, StorageKey::LANG->value, $newLang);

        $this->botActionService->sendReply(CommandKey::Start->value, $newLang, $chat);
    }
}
