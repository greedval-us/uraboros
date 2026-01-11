<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class SearchKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('search.inline.messages'))->action('search')->param('type', 'messages'),
            Button::make($t('search.inline.users'))->action('search')->param('type', 'users'),
            Button::make($t('search.inline.channels'))->action('search')->param('type', 'channels'),
        ]);
    }
}
