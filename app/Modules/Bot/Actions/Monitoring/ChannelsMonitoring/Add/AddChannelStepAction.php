<?php

namespace App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\Add;

use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AddChannelStepAction
{
    public function __construct(
        private BotActionService $botActionService,
        private StorageService $storageService,
        private DataBaseService $dataBaseService,
        private LangService $langService,
        private DataMapperService $dataService
    ) {}

    public function handle(TelegraphChat $chat, string $text, string $lang): void
    {
        $result = $this->dataBaseService->addChannelMonitoring($chat->chat_id, $text);
        
        $message = $this->langService->get($lang, 'monitoring.channels.limit_false');

        if($result) {
            $message = $this->langService->get($lang, 'monitoring.channels.limit_true');
        }    

        $messageId = $this
            ->botActionService
            ->sendInline(CommandKey::ChannelsM->value, $lang, $chat, $this->dataService->getMessagesData($message));

        $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
    }
}
