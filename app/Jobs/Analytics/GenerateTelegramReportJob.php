<?php

namespace App\Jobs\Analytics;

use App\Modules\Analytics\TelegramReportBuildService;
use App\Modules\Analytics\TelegramReportTaskService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GenerateTelegramReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;
    public int $timeout = 180;
    public bool $failOnTimeout = true;

    public function __construct(
        public readonly string $taskId,
        public readonly string $target,
        public readonly int $days,
        public readonly string $type,
        public readonly int $userId,
        public readonly string $lang = 'ru',
    ) {}

    public function handle(
        TelegramReportTaskService $taskService,
        TelegramReportBuildService $buildService,
    ): void {
        $taskService->markProcessing($this->taskId);

        try {
            $build = $buildService->build(
                type: $this->type,
                target: $this->target,
                days: $this->days,
                lang: $this->lang,
            );

            $pdfBinary = $buildService->renderPdf($build);

            $slug = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) ($build['entity']['title'] ?? $build['entity']['id'] ?? 'entity'));
            $from = (string) ($build['period']['from'] ?? 'from');
            $to = (string) ($build['period']['to'] ?? 'to');

            $fileName = "telegram_{$this->type}_{$slug}_{$from}_{$to}.pdf";
            $filePath = "reports/web/{$this->userId}/{$this->taskId}.pdf";

            Storage::disk('private')->put($filePath, $pdfBinary);

            $taskService->markCompleted($this->taskId, $filePath, $fileName);
        } catch (Throwable $exception) {
            $taskService->markFailed($this->taskId, $exception->getMessage());
        }
    }
}
