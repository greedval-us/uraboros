<?php

namespace App\Modules\Bot\Routes;


use App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\MyChannels\Card\BackToCardChannelAction;
use App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\MyChannels\Card\DeleteChannelAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class CardChannelRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::DelateChannelM->value => DeleteChannelAction::class,
            CommandKey::Back->value => BackToCardChannelAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
