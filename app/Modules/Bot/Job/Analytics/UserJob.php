<?php

namespace App\Modules\Bot\Job\Analytics;

use App\Modules\Bot\DTO\UserDTO;
use App\Modules\Bot\Job\JobTrait;
use App\Modules\Bot\Enums\CommandKey;
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
        try {
            $user = $this->apiServices->get("analytics/getUser/{$this->text}");
        } catch (\Throwable $e) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Ошибка при получении данных');
            return;
        }

        if(empty($user) || $user == null) {
            $this->botServices->sendText($this->chat, 'todo нет группы');
            return;
        }

        $infoUser = $this->dataMapperService->getUserTitleData(UserDTO::fromApi($user));

        $this->botServices->sendInline(CommandKey::UserA->value, $this->lang, $this->chat, $infoUser, ['user' => $this->text]);
        $this->botServices->delete($this->chat, $this->messageID);
    }
}
