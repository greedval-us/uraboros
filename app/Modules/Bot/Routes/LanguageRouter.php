<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Language\BackToSettingsAction;
use App\Modules\Bot\Actions\Language\SelectLanguageAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class LanguageRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $currentLang): void
    {
        $map = [
            CommandKey::Back->value => BackToSettingsAction::class,
        ];

        if (isset($map[$callback])) {
            app($map[$callback])->handle($chat, $currentLang);
            return;
        }

        app(SelectLanguageAction::class)->handle($chat, $callback);
    }
}
