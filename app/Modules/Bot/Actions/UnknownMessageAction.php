<?php

namespace App\Modules\Bot\Actions;

use App\Modules\Bot\Services\BotActionService;
use DefStudio\Telegraph\Models\TelegraphChat;

class UnknownMessageAction
{
    public function __construct(private BotActionService $botActionService) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $this->botActionService->sendText($chat, 'Не понимаю 😅, выберите кнопку из меню');
    }
}
