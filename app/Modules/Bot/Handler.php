<?php

namespace App\Modules\Bot;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use App\Modules\Bot\Enums\Lang;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Enums\CommandKey;
use Throwable;

class Handler extends WebhookHandler
{
    public function __construct(
        private readonly LangService $langService,
        private readonly BotActionService $botActionService,
        private readonly DataBaseService $dataBaseService,
        private readonly StorageService $storageService
    ) {}

    public function start(string $payload = '')
    {
        $this->dataBaseService->createUser($this->message->from(), $payload);
        $this->storageService->setMany($this->chat, [
        StorageKey::LANG ->value => Lang::RU->value,
        StorageKey::QUERY->value => '',
        StorageKey::MESSAGE->value => 0,
        StorageKey::MENU->value => ''
        ]);
        $this->botActionService->sendReply(CommandKey::Start->value, Lang::RU->value, $this->chat);
    }

    public function monitoring()
    {

    }

    public function search()
    {

    }

    public function account()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::Plans->value:

                break;
            case CommandKey::Stats->value:

                break;
            default:

                break;
        }
    }

    public function settings()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        switch ($callback) {
            case CommandKey::Language->value:
                $this->botActionService->delete($this->chat, $message_id);
                $mes_id = $this->botActionService->sendInline(CommandKey::Language->value, $lang, $this->chat);
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                break;
            default:

                break;
        }


    }

    public function language()
    {
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);
        $this->storageService->set($this->chat, StorageKey::LANG->value, $callback);
        $this->botActionService->sendReply(CommandKey::Start->value, $callback, $this->chat);
        $this->storageService->set($this->chat, StorageKey::MESSAGE->value, 0);
    }

    public function help()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::HowWorks->value:

                break;
            case CommandKey::Examples->value:

                break;
            case CommandKey::Faq->value:

                break;
            case CommandKey::Support->value:

                break;
            case CommandKey::Rules->value:

                break;
            default:

                break;
        }
    }

    protected function handleChatMessage(\Illuminate\Support\Stringable $text): void
    {
        response()->noContent()->send();

        $text = (string) $text;
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);

        $map = [
            'main_menu.buttons.monitoring' => CommandKey::Monitoring->value,
            'main_menu.buttons.search'     => CommandKey::Search->value,
            'main_menu.buttons.account'    => CommandKey::Account->value,
            'main_menu.buttons.settings'   => CommandKey::Settings->value,
            'main_menu.buttons.help'       => CommandKey::Help->value,
        ];

        foreach ($map as $langKey => $action) {
            if ($text === $this->langService->get($lang, $langKey)) {
                $this->botActionService->delete($this->chat, $this->messageId);
                $this->botActionService->delete($this->chat, $message_id);

                $mes_id = $this->botActionService->sendInline($action, $lang, $this->chat);

                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                return;
            }
        }

        $this->botActionService->sendText(
            $this->chat,
            'Не понимаю 😅, выберите кнопку из меню'
        );

    }

    protected function onFailure(Throwable $throwable): void
    {
        if ($throwable instanceof NotFoundHttpException) {
            throw $throwable;
        }

        report($throwable);

        $this->reply('sorry man, I failed');
    }
}

