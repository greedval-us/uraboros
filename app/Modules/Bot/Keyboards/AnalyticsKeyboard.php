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

    public function execute(string $lang, array $keyboard = []): Keyboard
    {
        $t = fn (string $key) => $this->langService->get($lang, $key);

        return Keyboard::make()->buttons([
            Button::make($t('analytics.inline.user'))->action('analytics')->param('type', 'a_user'),
            Button::make($t('analytics.inline.basic_metrics'))->action('analytics')->param('type', 'a_basic_metrics'),
            //Button::make($t('analytics.inline.retention'))->action('analytics')->param('type', 'a_retention'),
            Button::make($t('analytics.inline.funnel'))->action('analytics')->param('type', 'a_funnel'),
            Button::make($t('analytics.inline.audience_quality'))->action('analytics')->param('type', 'a_audience_quality'),
            //Button::make($t('analytics.inline.network_metrics'))->action('analytics')->param('type', 'a_network_metrics'),
            Button::make($t('analytics.inline.leaders'))->action('analytics')->param('type', 'a_users_leaders'),
        ]);
    }
}
