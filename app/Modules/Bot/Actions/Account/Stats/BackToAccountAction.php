<?php

namespace App\Modules\Bot\Actions\Account\Stats;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class BackToAccountAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService,
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->botActionService->sendInline(CommandKey::Account->value, $lang, $chat);

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
