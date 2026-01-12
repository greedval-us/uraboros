<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class AnalyticsKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('account.inline.profile'))->action('account')->param('type', 'profile'),
        ]);
    }
}
