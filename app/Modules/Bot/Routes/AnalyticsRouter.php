<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Analytics\OpenChannelAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenUserAnalyticsAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AnalyticsRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::ChannelA->value => OpenChannelAnalyticsAction::class,
            CommandKey::UserA->value => OpenUserAnalyticsAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
