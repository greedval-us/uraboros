<?php

namespace App\Modules\Bot\Services;

class BotMessageService
{
    public function __construct(
        private readonly KeyboardService $keyboardService
    ) {}

    public function build(string $messageKey, string $lang, array $replace = [], array $keyboard = []): array
    {
        $config = config("bot.messages.$messageKey");
        $text = LangService::get($lang, $config['text'], $replace);

        if (!array_key_exists('message', $replace)) {
            $text = str_replace(':message', '', $text);
        }

        return [
            'text' => LangService::get($lang, $text, $replace),
            'reply_keyboard' => isset($config['reply_keyboard'])
                ? $this->keyboardService->build(
                    $config['reply_keyboard'],
                    $lang,
                    $keyboard
                )
                : null,
        ];
    }
}
