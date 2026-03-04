<?php

namespace App\Modules\Report\Enums;

enum ReportType: string
{
    case BASIC = 'base_metrix';
    case AUDIENCE = 'audience_quality';
    case FUNNEL = 'funnel';
    case NETWORK = 'network_metrics';
    case RETENTION = 'retention';
    case DEFAULT = 'default';
}
