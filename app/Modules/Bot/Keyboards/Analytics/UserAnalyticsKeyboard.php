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
            Button::make($t('analytics.inline.user_7'))->action('report')
                ->param('type', 'a_user')
                ->param('query', $keyboard['user'])
                ->param('param', 7),

            Button::make($t('analytics.inline.user_30'))->action('report')
                ->param('type', 'a_user')
                ->param('query', $keyboard['user'])
                ->param('param', 30),

            Button::make($t('analytics.inline.user_365'))->action('report')
                ->param('type', 'a_user')
                ->param('query', $keyboard['user'])
                ->param('param', 365),
        ]);
    }
}
