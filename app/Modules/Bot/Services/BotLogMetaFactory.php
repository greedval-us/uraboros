<?php

namespace App\Modules\Bot\Services;

use Throwable;

class BotLogMetaFactory
{
    /**
     * @param mixed $message
     * @param mixed $chat
     * @param mixed $messageId
     * @param mixed $callbackQuery
     * @return array{telegram_id:?int,chat_id:?string,message_id:?int,callback_type:?string}
     */
    public function make(
        mixed $message,
        mixed $chat,
        mixed $messageId,
        mixed $callbackQuery,
    ): array {
        return [
            'telegram_id' => $this->telegramId($message),
            'chat_id' => $this->chatId($chat),
            'message_id' => $this->messageId($messageId),
            'callback_type' => $this->callbackType($callbackQuery),
        ];
    }

    private function telegramId(mixed $message): ?int
    {
        try {
            if (!$message || !method_exists($message, 'from')) {
                return null;
            }
            $from = $message->from();
            if (!$from || !method_exists($from, 'id')) {
                return null;
            }
            $id = $from->id();

            return is_numeric($id) ? (int) $id : null;
        } catch (Throwable) {
            return null;
        }
    }

    private function chatId(mixed $chat): ?string
    {
        try {
            if (!$chat || !method_exists($chat, 'id')) {
                return null;
            }

            $id = $chat->id();
            return $id === null ? null : (string) $id;
        } catch (Throwable) {
            return null;
        }
    }

    private function messageId(mixed $messageId): ?int
    {
        try {
            return is_numeric($messageId) ? (int) $messageId : null;
        } catch (Throwable) {
            return null;
        }
    }

    private function callbackType(mixed $callbackQuery): ?string
    {
        try {
            if (!$callbackQuery || !method_exists($callbackQuery, 'data')) {
                return null;
            }
            $data = $callbackQuery->data();
            if (!$data || !method_exists($data, 'get')) {
                return null;
            }

            $type = $data->get('type');
            return $type === null ? null : (string) $type;
        } catch (Throwable) {
            return null;
        }
    }
}

