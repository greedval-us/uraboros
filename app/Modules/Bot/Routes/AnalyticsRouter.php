<?php

namespace App\Modules\Bot\Routes;

use App\Modules\Bot\Actions\Analytics\OpenAudienceQualityAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenBasicMetricsAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenFunnelAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenNetworkMetricsAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenRetentionAnalyticsAction;
use App\Modules\Bot\Actions\Analytics\OpenUserAnalyticsAction;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AnalyticsRouter
{
    public function handle(TelegraphChat $chat, string $callback, string $lang): void
    {
        $map = [
            CommandKey::UserA->value            => OpenUserAnalyticsAction::class,
            CommandKey::BasicMetricsA->value    => OpenBasicMetricsAnalyticsAction::class,
            CommandKey::RetentionA->value       => OpenRetentionAnalyticsAction::class,
            CommandKey::FunnelA->value          => OpenFunnelAnalyticsAction::class,
            CommandKey::AudienceQualityA->value => OpenAudienceQualityAnalyticsAction::class,
            CommandKey::NetworkMetricsA->value  => OpenNetworkMetricsAnalyticsAction::class,
        ];

        if (!isset($map[$callback])) {
            return;
        }

        app($map[$callback])->handle($chat, $lang);
    }
}
