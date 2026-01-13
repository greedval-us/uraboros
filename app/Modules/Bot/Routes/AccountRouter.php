<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Account\OpenPlansAction;
use App\Modules\Bot\Actions\Account\OpenProfileAction;
use App\Modules\Bot\Actions\Account\OpenStatsAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AccountRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Profile->value => OpenProfileAction::class,
            CommandKey::Plans->value   => OpenPlansAction::class,
            CommandKey::Stats->value   => OpenStatsAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
