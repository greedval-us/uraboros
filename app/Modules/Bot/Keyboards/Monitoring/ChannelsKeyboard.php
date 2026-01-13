<?php

namespace App\Modules\Bot\Keyboards\Monitoring;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class ChannelsKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('monitoring.channels.inline.add_channel'))->action('chenelsMonitoring')->param('type', 'add_channel'),
            Button::make($t('monitoring.channels.inline.my_channels'))->action('chenelsMonitoring')->param('type', 'my_channels'),
            Button::make($t('monitoring.channels.inline.back'))->action('chenelsMonitoring')->param('type', 'back'),
        ]);
    }
}
    