<?php

namespace App\Modules\Bot\Keyboards;

use App\Modules\Bot\Contracts\KeyboardBuilderInterface;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;

class ReplyMenuKeyboard implements KeyboardBuilderInterface
{
    public function __construct(
        private readonly LangService $langService
    ) {}

    public function execute(string $lang, array $keyboard = []): Keyboard|ReplyKeyboard
    {
        $t = fn(string $key) => $this->langService->get($lang, $key);

        return ReplyKeyboard::make()
            ->row([
                ReplyButton::make($t('main_menu.buttons.monitoring')),
                ReplyButton::make($t('main_menu.buttons.analytics'))
                //ReplyButton::make($t('main_menu.buttons.search'))
            ])
            //->row([
            //    ReplyButton::make($t('main_menu.buttons.analytics'))->width(2)
            //])
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
