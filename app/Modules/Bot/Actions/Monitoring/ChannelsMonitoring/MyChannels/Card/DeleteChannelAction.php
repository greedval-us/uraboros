<?php

namespace App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\MyChannels\Card;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class DeleteChannelAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService,
        private DataBaseService $dataBaseService,
        private LangService $langService,
        private DataMapperService $dataService
    ) {}


    public function handle(TelegraphChat $chat, string $lang): void
    {
        $id = $this->storageService->get($chat, StorageKey::CHANNEL->value);

        $result = $this->dataBaseService->deleteMyChannel($id, $chat->chat_id);

        $data = $this->dataBaseService->getMyChannels($chat->chat_id);

        $keyboard = $this->dataService->getKeyboardData($data);

        $message = $this->langService->get($lang, 'monitoring.channels.my_channel.delete_false');

        if($result) {
            $message = $this->langService->get($lang, 'monitoring.channels.my_channel.delete_true');
        }    

        $messageId = $this->botActionService->sendInline(action: CommandKey::MyChennels->value, lang: $lang, chat: $chat, replace: $this->dataService->getMessagesData($message), keyboard: $keyboard);

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);

        $this->storageService->set($chat, StorageKey::MENU->value, 0);
    }
}
