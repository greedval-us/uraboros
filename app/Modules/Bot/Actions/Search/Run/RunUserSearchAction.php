<?php

namespace App\Modules\Bot\Actions\Search\Run;

use App\Modules\Bot\Job\Search\UserJob;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\LangService;
use DefStudio\Telegraph\Models\TelegraphChat;

class RunUserSearchAction
{
    public function __construct(
        private BotActionService $bot,
        private LangService $langService
    ) {}

    public function handle(TelegraphChat $chat, string $lang): void
    {
        $messageId = $this->bot->sendText($chat, $this->langService->get($lang, 'search.user.louding'));

        UserJob::dispatch();
    }
}
