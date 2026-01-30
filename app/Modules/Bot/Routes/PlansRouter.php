<?php

namespace App\Modules\Bot\Routes;


use App\Modules\Bot\Actions\Account\Plans\BackToAccountAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class PlansRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Back->value => BackToAccountAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
