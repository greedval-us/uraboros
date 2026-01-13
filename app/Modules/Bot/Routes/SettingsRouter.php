<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Settings\OpenLanguageSettingsAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class SettingsRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Language->value => OpenLanguageSettingsAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
