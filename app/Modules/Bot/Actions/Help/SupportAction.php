<?php

namespace App\Modules\Bot\Actions\Help;

use DefStudio\Telegraph\Models\TelegraphChat;

class SupportAction
{
    public function handle(TelegraphChat $chat, string $lang): void
    {
        // TODO: экран поиска каналов
    }
}
