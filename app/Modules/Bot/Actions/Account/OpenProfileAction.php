<?php

namespace App\Modules\Bot\Actions\Account;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenProfileAction
{
    public function __construct(
        private BotActionService $bot,
        private DataBaseService $db,
        private DataMapperService $mapper,
        private StorageService $storage
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $user = $this->db->getUser($chat->chat_id);

        $replace = $this->mapper->getProfileData($user);

        $messageId = $this->bot->sendInline(CommandKey::Profile->value, $lang, $chat, $replace);

        $this->storage->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
