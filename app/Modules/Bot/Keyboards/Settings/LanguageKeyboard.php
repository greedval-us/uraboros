<?php

namespace App\Modules\Bot\Keyboards\Settings;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class LanguageKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('settings.language.ru'))->action('language')->param('type', 'ru'),
            Button::make($t('settings.language.en'))->action('language')->param('type', 'en'),
        ]);
    }
}
