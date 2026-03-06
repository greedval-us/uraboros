<?php

namespace App\Modules\Bot\Enums;

enum StepMenuKey: string
{
    case AddChennel = "add_chennel";
    case SearchMessages = "search_messages";
    case SearchUser = "search_user";
    case SearchChannel = "search_channel";
    case AnalyticsUser = "analytics_user";
    case AnalyticsChannel = "analytics_channel";
    case AnalyticsBasicMetrics = 'analytics_basic_metrics';
    case AnalyticsRetention = 'analytics_retention';
    case AnalyticsFunnel = 'analytics_funnel';
    case AnalyticsAudienceQuality = 'analytics_audience_quality';
    case AnalyticsNetworkMetrics = 'analytics_network_metrics';
    case AnalyticsUsersLeaders = 'analytics_users_leaders';
}
