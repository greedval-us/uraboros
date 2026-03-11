<?php

namespace App\Modules\Bot\Enums;

enum KeyboardKey: string
{
    case ReplyMenu = 'reply_menu';
    case Monitoring = 'monitoring';
    case Search = 'search';
    case Analytics = 'analytics';
    case UserA = 'a_user';
    case ChannelA = 'a_channel';
    case BasicMetricsA = 'a_basic_metrics';
    case RetentionA = 'a_retention';
    case FunnelA = 'a_funnel';
    case AudienceQualityA = 'a_audience_quality';
    case NetworkMetricsA = 'a_network_metrics';
    case UsersLeadersA = 'a_users_leaders';
    case FullReportA = 'a_report_full';
    case Account = 'account';
    case Settings = 'settings';
    case Language = 'language';
    case Help = 'help';
    case HowWorks = 'how_it_works';
    case Examples = 'examples';
    case Faq = 'faq';
    case Support = 'support';
    case Profile = 'profile';
    case Rules = 'rules';
    case Plans = 'plans';
    case Stats = 'stats';
    case ChannelsM = 'm_channels';
    case AddChennel = 'add_channel';
    case MyChennels = 'my_channels';
    case CardMyChennels = 'card_my_channels';
    case DelateChannelM = 'delate_channel_m';
}
