<?php

namespace App\Modules\Bot\Job\Analytics;

use App\Modules\Bot\DTO\UserDTO;
use App\Modules\Bot\Job\JobTrait;
use App\Modules\Bot\Enums\CommandKey;
use App\Modules\Bot\Enums\LinkType;
use App\Modules\Bot\Helpers\TelegramHelper;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobTrait;

    public string $lang;
    public TelegraphChat $chat;
    public string $chatID;
    public string $messageID;
    public string $text;
    public $tries = 1;
    public $timeout = 120;
    public $failOnTimeout = true;
    public function __construct(string $lang, TelegraphChat $chat, string $chatID, string $messageID, string $text)
    {
        $this->lang = $lang;
        $this->chat = $chat;
        $this->chatID = $chatID;
        $this->messageID = $messageID;
        $this->text = $text;
    }
    public function handle(): void
    {
        $this->bootServices();

        $info = TelegramHelper::extractInfo($this->text, 1);
        $endpoint = 'analytics/getUser';
        $params = [];

        if (($info['type'] ?? null) === LinkType::Channelname && !empty($info['channel'])) {
            $params = ['username' => (string)$info['channel']];
        } elseif (in_array(($info['type'] ?? null), [LinkType::UserId, LinkType::ChatId], true) && !empty($info['value'])) {
            $params = ['id_user' => (string)$info['value']];
        } else {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Неверная данные для получения информации о канале. Пожалуйста, убедитесь, что вы отправили правильную ссылку или идентификатор канала.');
            return;
        }

        try {
            $user = $this->apiServices->get($endpoint, $params);
        } catch (\Throwable $e) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'РћС€РёР±РєР° РїСЂРё РїРѕР»СѓС‡РµРЅРёРё РґР°РЅРЅС‹С…');
            return;
        }

        if(empty($user) || $user == null) {
            $this->botServices->sendText($this->chat, 'todo нет пользователя с таким id');
            $this->botServices->delete($this->chat, $this->messageID);
            return;
        }

        $infoUser = $this->dataMapperService->getUserTitleData(UserDTO::fromApi($user));

        $this->botServices->sendInline(CommandKey::UserA->value, $this->lang, $this->chat, $infoUser, ['user' => $infoUser['id_user']]);
        $this->botServices->delete($this->chat, $this->messageID);
    }
}
