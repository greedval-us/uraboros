<?php

namespace App\Modules\Bot\Enums;

enum StepMenuKey: string
{
    case AddChennel = "add_chennel";
    case SearchMessages = "search_messages";
    case SearchUser = "search_user";
    case SearchChannel = "search_channel";
    case AnalyticsChannel = "analytics_channel";
    case AnalyticsUser = "analytics_user";
}
