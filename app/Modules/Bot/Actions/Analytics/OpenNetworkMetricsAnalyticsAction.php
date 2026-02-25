<?php

namespace App\Modules\Bot\Actions\Analytics;

use App\Modules\Bot\Enums\StepMenuKey;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Models\TelegraphChat;

class OpenNetworkMetricsAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private StorageService $storage,
        private LangService $langService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.user.screen'));

        $this->storage->set($chat, StorageKey::MESSAGE->value, $messageId);
        $this->storage->set($chat, StorageKey::MENU->value, StepMenuKey::AnalyticsNetworkMetrics->value);
    }
}
