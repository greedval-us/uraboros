<?php

namespace App\Modules\Bot\Job\Analytics;

use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\Job\JobTrait;
use App\Modules\Bot\Enums\CommandKey;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetentionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobTrait;

    public string $lang;
    public TelegraphChat $chat;
    public string $chatID;
    public string $messageID;
    public string $text;

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
            $group = $this->apiServices->get('analytics/getGroup/' . $this->text);
        } catch (\Throwable $e) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Ошибка при получении данных');
            return;
        }

        if(empty($group) || $group == null) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Нет группы todo');
            return;
        }

        $dto = GroupDTO::fromApi($group);

        $replace = $this->dataMapperService->getGroupTitleData($dto);

        $this->botServices->delete($this->chat, $this->messageID);
        $this->botServices->sendInline(CommandKey::RetentionA->value, $this->lang, $this->chat, $replace, ['group' => $this->text]);
    }
}
