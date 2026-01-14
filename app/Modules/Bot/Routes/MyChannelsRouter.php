<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\MyChannels\BackToMyChannelsAction;
use App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\MyChannels\OpenMyChannelCardAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class MyChannelsRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Back->value => BackToMyChannelsAction::class,
        ];

        if (isset($map[$callback])) {
            app($map[$callback])->handle($chat, $lang);
            return;
        }

        app(OpenMyChannelCardAction::class)->handle($chat,$lang, $callback);
    }
}
