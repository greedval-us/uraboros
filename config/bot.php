<?php

use App\Modules\Bot\Enums\KeyboardKey;
use App\Modules\Bot\Keyboards\Account\ProfileKeyboard;
use App\Modules\Bot\Keyboards\AccountKeyboard;
use App\Modules\Bot\Keyboards\HelpKeyboard;
use App\Modules\Bot\Keyboards\Monitoring\ChannelsKeyboard;
use App\Modules\Bot\Keyboards\MonitoringKeyboard;
use App\Modules\Bot\Keyboards\ReplyMenuKeyboard;
use App\Modules\Bot\Keyboards\SearchKeyboard;
use App\Modules\Bot\Keyboards\Settings\LanguageKeyboard;
use App\Modules\Bot\Keyboards\SettingsKeyboard;

return [
    'keyboards' => [
        KeyboardKey::ReplyMenu->value => ReplyMenuKeyboard::class,
        KeyboardKey::Monitoring->value => MonitoringKeyboard::class,
        KeyboardKey::ChannelsM->value => ChannelsKeyboard::class,
        KeyboardKey::Search->value => SearchKeyboard::class,
        KeyboardKey::Account->value => AccountKeyboard::class,
        KeyboardKey::Profile->value => ProfileKeyboard::class,
        KeyboardKey::Settings->value => SettingsKeyboard::class,
        KeyboardKey::Language->value => LanguageKeyboard::class,
        KeyboardKey::Help->value => HelpKeyboard::class,
    ],

    'messages' => [
        'start' => [
            'text' => 'main_menu.title',
            'reply_keyboard' => KeyboardKey::ReplyMenu->value,
        ],
        'monitoring' => [
            'text' => 'monitoring.screen',
            'reply_keyboard' => KeyboardKey::Monitoring->value,
        ],
        'add_channel' => [
            'text' => 'monitoring.screen',
            'reply_keyboard' => KeyboardKey::Monitoring->value,
        ],
        'm_channels' => [
            'text' => 'monitoring.channels.screen',
            'reply_keyboard' => KeyboardKey::ChannelsM->value,
        ],
        'search' => [
            'text' => 'search.screen',
            'reply_keyboard' => KeyboardKey::Search->value,
        ],
        's_channels' => [
            'text' => 'monitoring.screen',
            'reply_keyboard' => KeyboardKey::Monitoring->value,
        ],
        's_messages' => [
            'text' => 'monitoring.screen',
            'reply_keyboard' => KeyboardKey::Monitoring->value,
        ],
        's_users' => [
            'text' => 'monitoring.screen',
            'reply_keyboard' => KeyboardKey::Monitoring->value,
        ],
        'account' => [
            'text' => 'account.screen',
            'reply_keyboard' => KeyboardKey::Account->value,
        ],
        'profile' => [
            'text' => 'profile.screen',
            'reply_keyboard' => KeyboardKey::Profile->value,
        ],
        'plans' => [
            'text' => 'account.screen',
            'reply_keyboard' => KeyboardKey::Account->value,
        ],
        'stats' => [
            'text' => 'account.screen',
            'reply_keyboard' => KeyboardKey::Account->value,
        ],
        'settings' => [
            'text' => 'settings.screen',
            'reply_keyboard' => KeyboardKey::Settings->value,
        ],
        'language' => [
            'text' => 'settings.language.screen',
            'reply_keyboard' => KeyboardKey::Language->value,
        ],
        'help' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],
        'how_it_works' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],
        'examples' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],
        'faq' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],
        'support' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],
        'rules' => [
            'text' => 'help.screen',
            'reply_keyboard' => KeyboardKey::Help->value,
        ],

    ],
];
