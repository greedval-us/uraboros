<?php

namespace App\Modules\Bot\Keyboards\Analytics;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\Button;

class BasicMetricsAnalyticsKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('analytics.inline.week'))->action('report')
                ->param('type', 'a_basic_metrics')
                ->param('query', $keyboard['group'])
                ->param('param', 7),

            Button::make($t('analytics.inline.month'))->action('report')
                ->param('type', 'a_basic_metrics')
                ->param('query', $keyboard['group'])
                ->param('param', 30),
        ]);
    }
}
