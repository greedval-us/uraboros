<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

class MonitoringKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang): Keyboard|ReplyKeyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('monitoring.inline.channels'))->action('monitoring')->param('type', 'm_channels'),
            Button::make($t('monitoring.inline.messages'))->action('monitoring')->param('type', 'm_messages'),
            Button::make($t('monitoring.inline.users'))->action('monitoring')->param('type', 'm_users'),
        ]);
    }
}
