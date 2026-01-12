<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class HelpKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('help.inline.how_it_works'))->action('help')->param('type', 'how_it_works'),
            Button::make($t('help.inline.examples'))->action('help')->param('type', 'examples'),
            Button::make($t('help.inline.faq'))->action('help')->param('type', 'faq'),
            Button::make($t('help.inline.support'))->action('help')->param('type', 'support'),
            Button::make($t('help.inline.rules'))->action('help')->param('type', 'rules'),
        ]);
    }
}
