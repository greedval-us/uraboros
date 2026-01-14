<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\AddChannelAction;
use App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\BackToMonitoringAction;
use App\Modules\Bot\Actions\Monitoring\chenelsMonitoring\OpenMyChannelAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class ChannelsMonitoringRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::AddChennel->value => AddChannelAction::class,
            CommandKey::MyChennels->value => OpenMyChannelAction::class,
            CommandKey::Back->value       => BackToMonitoringAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
