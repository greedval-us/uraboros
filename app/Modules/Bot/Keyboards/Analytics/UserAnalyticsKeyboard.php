<?php

namespace App\Modules\Bot\Keyboards\Analytics;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class UserAnalyticsKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('account.inline.profile'))->action('account')->param('type', 'profile'),
            Button::make($t('account.inline.plans'))->action('account')->param('type', 'plans'),
            Button::make($t('account.inline.stats'))->action('account')->param('type', 'stats'),
        ]);
    }
}
