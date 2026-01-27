<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\MainMenuAction;
use App\Modules\Bot\Actions\Monitoring\ChannelsMonitoring\Add\AddChannelStepAction;
use App\Modules\Bot\Actions\Search\Run\RunChannelSearchAction;
use App\Modules\Bot\Actions\Search\Run\RunMessageSearchAction;
use App\Modules\Bot\Actions\Search\Run\RunUserSearchAction;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StepMenuKey;
use App\Modules\Bot\Actions\UnknownMessageAction;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class ChatMessageRouter
{
    public function handle(TelegraphChat $chat, string $text, string $lang): void
    {
        $mainMenuMap = [
            'main_menu.buttons.monitoring' => CommandKey::Monitoring->value,
            'main_menu.buttons.search'     => CommandKey::Search->value,
            'main_menu.buttons.account'    => CommandKey::Account->value,
            'main_menu.buttons.settings'   => CommandKey::Settings->value,
            'main_menu.buttons.help'       => CommandKey::Help->value,
            'main_menu.buttons.analytics'  => CommandKey::Analytics->value,
        ];

        foreach ($mainMenuMap as $langKey => $action) {
            if ($text === app(LangService::class)->get($lang, $langKey)) {
                app(MainMenuAction::class)->handle($chat, $action, $lang);
                return;
            }
        }

        $stepActionsMap = [
            StepMenuKey::AddChennel->value => AddChannelStepAction::class,
            StepMenuKey::SearchUser->value => RunUserSearchAction::class,
            StepMenuKey::SearchChannel->value => RunChannelSearchAction::class,
            StepMenuKey::SearchMessages->value => RunMessageSearchAction::class,
        ];

        $stepMenu = app(StorageService::class)->get($chat, StorageKey::MENU->value);

        if ($stepMenu && isset($stepActionsMap[$stepMenu])) {
            app($stepActionsMap[$stepMenu])->handle($chat, $text, $lang);
            return;
        }

        app(UnknownMessageAction::class)->handle($chat, $lang);
    }
}
