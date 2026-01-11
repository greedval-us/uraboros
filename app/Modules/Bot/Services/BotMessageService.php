<?php

namespace App\Modules\Bot\Services;

class BotMessageService
{
    public function __construct(
        private readonly KeyboardService $keyboardService
    ) {}

    public function build(string $messageKey, string $lang, array $replace = []): array
    {
        $config = config("bot.messages.$messageKey");

        return [
            'text' => LangService::get($lang, $config['text'], $replace),
            'reply_keyboard' => isset($config['reply_keyboard'])
                ? $this->keyboardService->build(
                    $config['reply_keyboard'],
                    $lang
                )
                : null,
        ];
    }
}
