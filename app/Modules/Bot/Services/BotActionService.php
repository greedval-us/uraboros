<?php

namespace App\Modules\Bot\Services;

use DefStudio\Telegraph\Models\TelegraphChat;

class BotActionService
{
    public function sendReply(string $action, string $lang, TelegraphChat $chat): int
    {
        $message = app(BotMessageService::class)->build($action, $lang);

        $result = $chat->message($message['text'])
            ->replyKeyboard($message['reply_keyboard'])
            ->send();

        return $result->telegraphMessageId();
    }


    public function sendInline(string $action, string $lang, TelegraphChat $chat, $replace = []): int
    {
        $message = app(BotMessageService::class)->build($action, $lang, $replace);

        $result = $chat->message($message['text'])
            ->Keyboard($message['reply_keyboard'])
            ->send();

        return $result->telegraphMessageId();
    }

    public function sendText(TelegraphChat $chat, string $text): int
    {
        $result = $chat->message($text)->send();
        return $result->telegraphMessageId();
    }

    public function edit( TelegraphChat $chat, int $messageId, string $text): void {
        $chat->editMessage($messageId)
            ->text($text)
            ->send();
    }

    public function delete(TelegraphChat $chat, int $messageId): void
    {
        $chat->deleteKeyboard($messageId)
            ->deleteMessage($messageId)
            ->send();
    }
}
