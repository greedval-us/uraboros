<?php

namespace App\Modules\Bot\Enums;

enum CommandKey: string
{
    case Start = 'start';
    case Monitoring = 'monitoring';
    case Search = 'search';
    case Account = 'account';
    case Settings = 'settings';
    case Help = 'help';
    case Language = 'language';
    case HowWorks = 'how_it_works';
    case Examples = 'examples';
    case Faq = 'faq';
    case Support = 'support';
    case Rules = 'rules';
    case Plans = 'plans';
    case Stats = 'stats';
}
