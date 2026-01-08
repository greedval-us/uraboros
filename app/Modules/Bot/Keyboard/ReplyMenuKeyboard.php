<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modulses\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

class ReplyMenuKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang ): Keyboard|ReplyKeyboard
    {
        $t = fn(string $key) => $this->langService->get($key, $lang);

        return ReplyKeyboard::make()
            ->row([
                ReplyButton::make($t('main_menu.buttons.monitoring')),
                ReplyButton::make($t('main_menu.buttons.search'))
            ])
            ->row([
                ReplyButton::make($t('main_menu.buttons.account')),
                ReplyButton::make($t('main_menu.buttons.settings'))
            ])
            ->row([
                ReplyButton::make($t('main_menu.buttons.help'))->width(2)
            ])
            ->resize();
    }
}
