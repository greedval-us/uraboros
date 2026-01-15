<?php

namespace App\Modules\Bot\Keyboards\Monitoring;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class CardChannelKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('monitoring.channels.card_inline.delete'))->action('cardChannel')->param('type', 'delate_channel_m'),
            Button::make($t('monitoring.channels.card_inline.back'))->action('cardChannel')->param('type', 'back'),
        ]);
    }
}
    