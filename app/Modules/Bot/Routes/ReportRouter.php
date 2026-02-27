<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Analytics\Report\ReportAudienceQualityAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\Report\ReportBasicMetricsAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\Report\ReportFunnelAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\Report\ReportNetworkMetricsAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\Report\ReportRetentionAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\Report\ReportUserAnalyticsAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class ReportRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $param, string $query, string $lang): void
    {
        $map = [
            CommandKey::UserA->value            => ReportUserAnalyticsAction::class,
            CommandKey::BasicMetricsA->value    => ReportBasicMetricsAnalyticsAction::class,
            CommandKey::RetentionA->value       => ReportRetentionAnalyticsAction::class,
            CommandKey::FunnelA->value          => ReportFunnelAnalyticsAction::class,
            CommandKey::AudienceQualityA->value => ReportAudienceQualityAnalyticsAction::class,
            CommandKey::NetworkMetricsA->value  => ReportNetworkMetricsAnalyticsAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $param, $query, $lang);
    }
}
