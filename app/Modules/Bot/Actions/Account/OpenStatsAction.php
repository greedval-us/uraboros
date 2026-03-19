<?php

namespace App\Modules\Bot\Actions\Account;

use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenStatsAction
{
    public function __construct(
        private BotActionService $bot,
        private DataBaseService $db,
        private DataMapperService $mapper,
        private StorageService $storage
    ) {}
    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, 'В разработке  todo');

        $this->storage->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
