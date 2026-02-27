<?php

use App\Modules\Bot\Enums\KeyboardKey;
use App\Modules\Bot\Keyboards\Account\PlansKeyboard;
use App\Modules\Bot\Keyboards\Account\ProfileKeyboard;
use App\Modules\Bot\Keyboards\AccountKeyboard;
use App\Modules\Bot\Keyboards\Analytics\AudienceQualityAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\Analytics\BasicMetricsAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\Analytics\FunnelAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\Analytics\NetworkMetricsAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\Analytics\RetentionAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\Analytics\UserAnalyticsKeyboard;
use App\Modules\Bot\Keyboards\AnalyticsKeyboard;
use App\Modules\Bot\Keyboards\HelpKeyboard;
use App\Modules\Bot\Keyboards\Monitoring\CardChannelKeyboard;
use App\Modules\Bot\Keyboards\Monitoring\ChannelsKeyboard;
use App\Modules\Bot\Keyboards\Monitoring\MyChannelsKeyboard;
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
        KeyboardKey::MyChennels->value => MyChannelsKeyboard::class,
        KeyboardKey::CardMyChennels->value => CardChannelKeyboard::class,
        KeyboardKey::Analytics->value => AnalyticsKeyboard::class,
        KeyboardKey::UserA->value => UserAnalyticsKeyboard::class,
        KeyboardKey::BasicMetricsA->value => BasicMetricsAnalyticsKeyboard::class,
        KeyboardKey::RetentionA->value => RetentionAnalyticsKeyboard::class,
        KeyboardKey::FunnelA->value => FunnelAnalyticsKeyboard::class,
        KeyboardKey::AudienceQualityA->value => AudienceQualityAnalyticsKeyboard::class,
        KeyboardKey::NetworkMetricsA->value => NetworkMetricsAnalyticsKeyboard::class,
        KeyboardKey::Plans->value => PlansKeyboard::class,
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
        'm_channels' => [
            'text' => 'monitoring.channels.screen',
            'reply_keyboard' => KeyboardKey::ChannelsM->value,
        ],
        'my_channels' => [
            'text' => 'monitoring.channels.my_channel.screen',
            'reply_keyboard' => KeyboardKey::MyChennels->value,
        ],
        'card_my_channels' => [
            'text' => 'monitoring.channels.card.screen',
            'reply_keyboard' => KeyboardKey::CardMyChennels->value,
        ],
        'search' => [
            'text' => 'search.screen',
            'reply_keyboard' => KeyboardKey::Search->value,
        ],
        'analytics' => [
            'text' => 'analytics.screen',
            'reply_keyboard' => KeyboardKey::Analytics->value,
        ],
        'account' => [
            'text' => 'account.screen',
            'reply_keyboard' => KeyboardKey::Account->value,
        ],

        'a_user' => [
            'text' => 'analytics.user.screen',
            'reply_keyboard' => KeyboardKey::UserA->value,
        ],
        'a_basic_metrics' => [
            'text' => 'analytics.basic_metrics.screen',
            'reply_keyboard' => KeyboardKey::BasicMetricsA->value,
        ],
        'a_retention' => [
            'text' => 'analytics.retention.screen',
            'reply_keyboard' => KeyboardKey::RetentionA->value,
        ],
        'a_funnel' => [
            'text' => 'analytics.funnel.screen',
            'reply_keyboard' => KeyboardKey::FunnelA->value,
        ],
        'a_audience_qualityr' => [
            'text' => 'analytics.audience_quality.screen',
            'reply_keyboard' => KeyboardKey::AudienceQualityA->value,
        ],
        'a_network_metrics' => [
            'text' => 'analytics.network_metrics.screen',
            'reply_keyboard' => KeyboardKey::NetworkMetricsA->value,
        ],

        'profile' => [
            'text' => 'account.profile.screen',
            'reply_keyboard' => KeyboardKey::Profile->value,
        ],
        'plans' => [
            'text' => 'account.plans.screen',
            'reply_keyboard' => KeyboardKey::Plans->value,
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
