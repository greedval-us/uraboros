<?php

namespace App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\MyChannels;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenMyChannelCardAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService,
        private DataBaseService $dataBaseService,
        private DataMapperService $mapperService
    ) {}

    public function handle(TelegraphChat $chat, string $lang, int $id): void
    {
        $data = $this->dataBaseService->getMyChannel($id);
        $replace = $this->mapperService->getMyChannelData($data);
        $this->storageService->set($chat, StorageKey::CHANNEL->value, $id);
        $messageId = $this->botActionService
            ->sendInline(action: CommandKey::CardMyChennels->value, lang: $lang, chat: $chat, replace: $replace, keyboard: ['id' => $id]);

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
