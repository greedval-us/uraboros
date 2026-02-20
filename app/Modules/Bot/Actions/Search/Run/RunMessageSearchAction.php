<?php

namespace App\Modules\Bot\Actions\Search\Run;

use App\Modules\Bot\Job\Search\MessagesJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Models\TelegraphChat;

class RunMessageSearchAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'search.message.louding'));

        MessagesJob::dispatch();
    }
}
