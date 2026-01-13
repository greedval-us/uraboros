<?php

namespace App\Modules\Bot;

use App\Modules\Bot\Services\BotActionService;
use App\Modules\Bot\Services\DataBaseService;
use App\Modules\Bot\Services\DataMapperService;
use App\Modules\Bot\Services\LangService;
use App\Modules\Bot\Services\StorageService;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use App\Modules\Bot\Enums\Lang;
use App\Modules\Bot\Enums\StorageKey;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\StepMenuKey;
use Throwable;

class Handler extends WebhookHandler
{
    public function __construct(
        private readonly LangService $langService,
        private readonly BotActionService $botActionService,
        private readonly DataBaseService $dataBaseService,
        private readonly StorageService $storageService,
        private readonly DataMapperService $dataMapperService
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
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::ChannelsM->value:
                $mes_id = $this->botActionService->sendInline(CommandKey::ChannelsM->value, $lang, $this->chat);
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                break;
            default:

                break;
        }
    }

    public function chenelsMonitoring()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::AddChennel->value:
                $mes_id = $this->botActionService->sendText($this->chat, $this->langService->get($lang, 'monitoring.channels.add_channel.screen'));
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                $this->storageService->set($this->chat, StorageKey::MENU->value, StepMenuKey::AddChennel->value);
                break;
            case CommandKey::MyChennels->value:

                break;
            case CommandKey::Back->value:
                $mes_id = $this->botActionService->sendInline(CommandKey::Monitoring->value, $lang, $this->chat);
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                break;
                
            default:

                break;
        }
    }

    public function search()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        switch ($callback) {
            case CommandKey::ChannelsS->value:

                break;
            case CommandKey::MessagesS->value:

                break;
            case CommandKey::UsersS->value:

                break;
            default:

                break;
        }
    }
    public function analytics()
    {


    }

    public function account()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::Profile->value:
                $user = $this->dataBaseService->getUser($this->chat->chat_id);
                $replace = $this->dataMapperService->getProfileData($user);
                $mes_id = $this->botActionService->sendInline(CommandKey::Profile->value, $lang, $this->chat, $replace);
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                break;
            case CommandKey::Plans->value:

                break;
            case CommandKey::Stats->value:

                break;
            default:

                break;
        }
    }

    public function profile()
    {
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $message_id = $this->storageService->get($this->chat, StorageKey::MESSAGE->value);
        $callback = $this->callbackQuery->data()->get('type');

        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::Free->value:
                $user = $this->dataBaseService->getUser($this->chat->chat_id);
                $replace = $this->dataMapperService->getProfileData($user);
                $this->dataBaseService->getFreeRequest($this->chat->chat_id);
                $mes_id = $this->botActionService->sendInline(CommandKey::Profile->value, $lang, $this->chat, $replace);
                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                break;
            case CommandKey::Back->value:
                $mes_id = $this->botActionService->sendInline(CommandKey::Account->value, $lang, $this->chat);

                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
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
        $this->botActionService->delete($this->chat, $message_id);

        switch ($callback) {
            case CommandKey::Language->value:
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
        $lang = $this->storageService->get($this->chat, StorageKey::LANG->value);
        $this->botActionService->delete($this->chat, $message_id);
        $this->storageService->set($this->chat, StorageKey::MESSAGE->value, 0);

        if($callback === CommandKey::Back->value) {
            $mes_id = $this->botActionService->sendInline(CommandKey::Settings->value, $lang, $this->chat);
            $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
            return;
        }

        $this->storageService->set($this->chat, StorageKey::LANG->value, $callback);
        $this->botActionService->sendReply(CommandKey::Start->value, $callback, $this->chat);

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
            'main_menu.buttons.analytics'  => CommandKey::Analytics->value,
        ];
        
        $this->botActionService->delete($this->chat, $this->messageId);
        $this->botActionService->delete($this->chat, $message_id);

        foreach ($map as $langKey => $action) {
            if ($text === $this->langService->get($lang, $langKey)) {
                $mes_id = $this->botActionService->sendInline($action, $lang, $this->chat);

                $this->storageService->set($this->chat, StorageKey::MESSAGE->value, $mes_id);
                $this->storageService->set($this->chat, StorageKey::MENU->value, '');
                return;
            }
        }
        
        $menu = $this->storageService->get($this->chat, StorageKey::MENU->value);

        switch ($menu) {
            case StepMenuKey::AddChennel->value:
                
                break;
            default:

                break;
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

