<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Help\FaqAction;
use App\Modules\Bot\Actions\Help\RulesAction;
use App\Modules\Bot\Actions\Help\SupportAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class HelpRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::Faq->value      => FaqAction::class,
            CommandKey::Support->value  => SupportAction::class,
            CommandKey::Rules->value    => RulesAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
