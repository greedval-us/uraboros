<?php

namespace App\Modules\Bot\Job\Analytics;

use DefStudio\Telegraph\Facades\Telegraph;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChannelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $lang;
    public string $chatID;
    public string $messageID;

    public function __construct(string $lang, string $chatID, string $messageID)
    {
        $this->lang = $lang;
        $this->chatID = $chatID;
        $this->messageID = $messageID;
    }

    public function handle(): void
    {
        Telegraph::chat($this->chatID)
            ->message('work')
            ->send();
    }
}
