<?php

namespace App\Modules\Bot\Enums;

enum KeyboardKey: string
{
    case ReplyMenu = 'reply_menu';
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
    case Rules = 'rules';
    case Plans = 'plans';
    case Stats = 'stats';
    case ChannelsM = 'm_channels';
    case MessagesM = 'm_messages';
    case UsersM = 'm_users';
    case ChannelsS = 's_channels';
    case MessagesS = 's_messages';
    case UsersS = 's_users';
}
