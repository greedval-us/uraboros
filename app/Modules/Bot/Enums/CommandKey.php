<?php

namespace App\Modules\Bot\Enums;

enum CommandKey: string
{
    case Start = 'start';
    case Monitoring = 'monitoring';
    case Search = 'search';
    case Analytics = 'analytics';
    case Account = 'account';
    case Settings = 'settings';
    case Language = 'language';
    case Help = 'help';
    case HowWorks = 'how_it_works';
    case Examples = 'examples';
    case Faq = 'faq';
    case Support = 'support';
    case Profile = 'profile';
    case Free = 'free';
    case Rules = 'rules';
    case Plans = 'plans';
    case Stats = 'stats';
    case ChannelsM = 'm_channels';
    case AddChennel = 'add_channel';
    case MyChennels = 'my_channels';
    case DelateChannelM = 'delate_channel_m';
    case CardMyChennels = 'card_my_channels';
    case ChannelsS = 's_channels';
    case MessagesS = 's_messages';
    case UsersS = 's_users';
    case Back = 'back';
}
