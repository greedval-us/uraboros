<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Search\OpenChannelSearchAction;
use App\Modules\Bot\Actions\Search\OpenMessageSearchAction;
use App\Modules\Bot\Actions\Search\OpenUserSearchAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class SearchRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::ChannelsS->value => OpenChannelSearchAction::class,
            CommandKey::MessagesS->value => OpenMessageSearchAction::class,
            CommandKey::UsersS->value    => OpenUserSearchAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
