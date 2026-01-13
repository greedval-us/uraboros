<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Monitoring\OpenChannelsMonitoringAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class MonitoringRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::ChannelsM->value => OpenChannelsMonitoringAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
