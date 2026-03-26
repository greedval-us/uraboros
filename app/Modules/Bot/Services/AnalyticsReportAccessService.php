<?php

namespace App\Modules\Bot\Services;

use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class AnalyticsReportAccessService
{
    public function __construct(
        private readonly BotActionService $bot,
        private readonly LangService $langService,
        private readonly DataBaseService $dataBaseService,
        private readonly StorageService $storageService
    ) {}

    public function startReport(
        TelegraphChat $chat,
        string $lang,
        string $reportKey = 'default',
        ?int $costOverride = null
    ): ?int {
        $defaultCost = (int) config('bot.analytics.report_costs.default', 1);
        $cost = $costOverride ?? (int) config("bot.analytics.report_costs.$reportKey", $defaultCost);

        $canRun = $this->dataBaseService->canMakeAction($chat->chat_id, $cost);

        if (!$canRun) {
            $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.no_prise'));
            $this->storageService->set($chat, StorageKey::MESSAGE->value, $messageId);
            return null;
        }

        return $this->bot->sendText($chat, $this->langService->get($lang, 'analytics.louding'));
    }
}
