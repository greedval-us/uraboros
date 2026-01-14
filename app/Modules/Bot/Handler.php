<?php

namespace App\Modules\Bot;

use App\Modules\Bot\Routes\AccountRouter;
use App\Modules\Bot\Routes\ChannelsMonitoringRouter;
use App\Modules\Bot\Routes\ChatMessageRouter;
use App\Modules\Bot\Routes\HelpRouter;
use App\Modules\Bot\Routes\LanguageRouter;
use App\Modules\Bot\Routes\MonitoringRouter;
use App\Modules\Bot\Routes\MyChannelsRouter;
use App\Modules\Bot\Routes\ProfileRouter;
use App\Modules\Bot\Routes\SearchRouter;
use App\Modules\Bot\Routes\SettingsRouter;
use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use App\Modules\Bot\Enums\Lang;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Enums\CommandKey;
use Log;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends WebhookHandler
{
    public function __construct(
        private readonly LangService $langService,
        private readonly BotActionService $botActionService,
        private readonly DataBaseService $dataBaseService,
        private readonly StorageService $storageService,
        private readonly DataMapperService $dataMapperService,
        private readonly MonitoringRouter $monitoringRouter,
        private readonly ChannelsMonitoringRouter $channelsMonitoringRouter,
        private readonly SearchRouter $searchRouter,
        private readonly AccountRouter $accountRouter,
        private readonly ProfileRouter $profileRouter,
        private readonly SettingsRouter $settingsRouter,
        private readonly LanguageRouter $languageRouter,
        private readonly HelpRouter $helpRouter,
        private readonly ChatMessageRouter $chatMessageRouter,
        private readonly MyChannelsRouter $myChannelsRouter
    ) {}

    public function start(string $payload = '')
    {
        $this->dataBaseService->createUser($this->message->from(), $payload);
        $this->storageService->setMany($this->chat, [
            StorageKey::LANG->value => Lang::RU->value,
            StorageKey::QUERY->value => '',
            StorageKey::MESSAGE->value => 0,
            StorageKey::MENU->value => ''
        ]);
        $this->botActionService->sendReply(CommandKey::Start->value, Lang::RU->value, $this->chat);
    }

    public function monitoring()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->monitoringRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function chenelsMonitoring()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->channelsMonitoringRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function myChannels()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->myChannelsRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }
    public function search()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->searchRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function account()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->accountRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function profile()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->profileRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function settings()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->settingsRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    public function language()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->languageRouter->handle(chat: $this->chat, callback: $callback, currentLang: $lang);
    }

    public function help()
    {
        response()->noContent()->send();
        $this->clearMessage();
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->helpRouter->handle(chat: $this->chat, callback: $callback, lang: $lang);
    }

    protected function handleChatMessage(\Illuminate\Support\Stringable $text): void
    {
        response()->noContent()->send();

        $text = (string) $text;
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);

        $this->botActionService->delete($this->chat, $this->messageId);
        $this->clearMessage();

        $this->chatMessageRouter->handle(chat: $this->chat, text: $text, lang: $lang);
    }

    private function clearMessage(): void
    {
        $messageId = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $this->botActionService->delete($this->chat, $messageId);
        $this->storageService->set($this->chat, StorageKey::MESSAGE->value, 0);
    }

    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        if ($throwable instanceof HttpExceptionInterface) {
            Log::warning('Bot HTTP exception', [
                'status' => $throwable->getStatusCode(),
                'message' => $throwable->getMessage(),
            ]);
        } else {
            Log::error('Bot unhandled exception', [
                'exception' => $throwable,
            ]);
        }

        $this->reply(
            __('bot.errors.generic')
        );
    }
}
