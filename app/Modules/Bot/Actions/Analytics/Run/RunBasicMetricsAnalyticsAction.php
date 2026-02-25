<?php

namespace App\Modules\Bot\Actions\Analytics\Run;

use App\Modules\Bot\Job\Search\ChannelJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Models\TelegraphChat;

class RunBasicMetricsAnalyticsAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'search.channel.louding'));

        ChannelJob::dispatch($lang, $chat->chat_id, $messageId);
    }
}
