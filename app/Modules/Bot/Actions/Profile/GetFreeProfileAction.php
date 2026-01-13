<?php

namespace App\Modules\Bot\Actions\Profile;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class GetFreeProfileAction
{
    public function __construct(
        private BotActionService $botActionService,
        private DataBaseService $dataBaseService,
        private DataMapperService $dataMapperService,
        private StorageService $storageService,
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $user = $this->dataBaseService->getUser($chat->chat_id);

        $this->dataBaseService->getFreeRequest($chat->chat_id);

        $replace = $this->dataMapperService->getProfileData($user);

        $messageId = $this->botActionService->sendInline(CommandKey::Profile->value, $lang, $chat, $replace);

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
