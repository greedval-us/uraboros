<?php

namespace App\Modules\Bot\Keyboards\Account;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class ProfileKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('profile.inline.free'))->action('profile')->param('type', 'free'),
            Button::make($t('profile.inline.back'))->action('profile')->param('type', 'back'),
        ]);
    }
}
