<?php

namespace App\Modules\Bot\Job\Analytics\Report;

use App\Modules\Bot\DTO\AnalyticDTO;
use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\Job\JobTrait;
use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Enums\ReportType;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExportUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobTrait;

    public string $lang;
    public TelegraphChat $chat;
    public string $chatID;
    public string $messageID;
    public string $query;
    public string $param;
    public $tries = 1;
    public $timeout = 120;
    public $failOnTimeout = true;
    public function __construct(string $lang, TelegraphChat $chat, string $chatID, string $messageID, string $query, int $param)
    {
        $this->lang = $lang;
        $this->chat = $chat;
        $this->chatID = $chatID;
        $this->messageID = $messageID;
        $this->query = $query;
        $this->param = $param;
    }

    public function handle(): void
    {
        $this->bootServices();

        try {
            $days = (int) $this->param;

            $to = Carbon::now('UTC');
            $from = Carbon::now('UTC')->subDays($days);

            $user = $this->apiServices->get("analytics/getUser/{$this->query}");
            $analytic = $this->apiServices->get('analytics/getBaseAnalyticUser', ['from' => $from->toIso8601String(), 'to' => $to->toIso8601String(), 'id_group' => $this->query]);
            $changedUser = $this->apiServices->get('analytics/getUserChanged', ['from' => $from->toIso8601String(), 'to' => $to->toIso8601String(), 'id_group' => $this->query]);

        } catch (\Throwable $e) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Ошибка при получении данных');
            return;
        }

        if(empty($analytic) || $analytic == null) {
            $this->botServices->delete($this->chat, $this->messageID);
            $this->botServices->sendText($this->chat, 'Нет данных todo');
            return;
        }

        Log::info($analytic);
        Log::info($changedUser);
        /*$pdf = $this->pdfReportServices->generate($context, ReportType::RETENTION);

        $filePath = "reports/{$this->chatID}/group_{$groupDto->idGroup}_{$to}.pdf";

        Storage::disk('private')->put($filePath, $pdf->output());

        $this->botServices->delete($this->chat, $this->messageID);
        $this->botServices->sendFile($this->chat, $filePath);*/
    }
}
