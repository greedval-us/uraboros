<?php

namespace App\Modules\Bot\Actions\Help;

use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class FaqAction
{
    public function __construct(
        private BotActionService $bot,
        private StorageService $storage,
        private LangService $langService
    ) {}
public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'help.FAQ'));

        $this->storage->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
