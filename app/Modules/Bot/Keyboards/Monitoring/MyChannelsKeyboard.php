<?php

namespace App\Modules\Bot\Keyboards\Monitoring;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class MyChannelsKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        $buttons = [];

        foreach ($keyboard as $key => $value) {
            $buttons[] = Button::make($value)->action('myChannels')->param('type', (string) $key);
        }

        $buttons[] = Button::make($t('monitoring.channels.my_channel.back'))->action('myChannels')->param('type', 'back');

        return Keyboard::make()->buttons($buttons);
    }
}