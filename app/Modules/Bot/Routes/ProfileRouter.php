<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Profile\BackToAccountAction;
use App\Modules\Bot\Actions\Profile\GetFreeProfileAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class ProfileRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Free->value => GetFreeProfileAction::class,
            CommandKey::Back->value => BackToAccountAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
