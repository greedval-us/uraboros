<?php

namespace App\Jobs\Analytics;

use App\Modules\Analytics\TelegramReportTaskService;
use App\Modules\Bot\DTO\AudienceQualityDTO;
use App\Modules\Bot\DTO\BasicMetriicsDTO;
use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Report\DTO\AudienceQualityContextDTO;
use App\Modules\Report\DTO\BasicMetricsContextDTO;
use App\Modules\Report\Enums\ReportType;
use App\Modules\Report\Pdf\PdfReportService;
use App\Modules\UraborosApi\Contracts\UraborosApiInterface;
use Carbon\Carbon;
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
    public int $timeout = 120;
    public bool $failOnTimeout = true;

    public function __construct(
        public readonly string $taskId,
        public readonly string $channel,
        public readonly int $days,
        public readonly string $type,
        public readonly int $userId,
        public readonly string $lang = 'ru',
    ) {}

    public function handle(
        TelegramReportTaskService $taskService,
        UraborosApiInterface $api,
        PdfReportService $pdfReportService,
    ): void {
        $taskService->markProcessing($this->taskId);

        try {
            $groupFilter = $this->resolveGroupFilter($this->channel);

            if ($groupFilter === null) {
                throw new \InvalidArgumentException('Неверный формат канала для отчета.');
            }

            $group = $api->get('analytics/getGroup', $groupFilter);

            if (empty($group)) {
                throw new \InvalidArgumentException('Канал не найден в аналитической базе.');
            }

            $idGroup = (string) ($group['idGroup'] ?? '');

            if ($idGroup === '') {
                throw new \InvalidArgumentException('Для канала не найден id_group.');
            }

            $to = Carbon::yesterday('UTC')->endOfDay();
            $from = $to->copy()->subDays($this->days);

            $groupDto = GroupDTO::fromApi($group);

            if ($this->type === 'audience') {
                $analytic = $api->get('analytics/getAudienceQuality', [
                    'from' => $from->toIso8601String(),
                    'to' => $to->toIso8601String(),
                    'id_group' => $idGroup,
                ]);

                $context = new AudienceQualityContextDTO(
                    group: $groupDto,
                    audienceQualityDTO: AudienceQualityDTO::fromApi($analytic),
                    lang: $this->lang,
                    days: $this->days,
                    to: $to->toDateString(),
                    from: $from->toDateString(),
                );

                $pdf = $pdfReportService->generate($context, ReportType::AUDIENCE);
            } else {
                $analytic = $api->get('analytics/getBaseMetrics', [
                    'from' => $from->toIso8601String(),
                    'to' => $to->toIso8601String(),
                    'id_group' => $idGroup,
                ]);

                $context = new BasicMetricsContextDTO(
                    group: $groupDto,
                    basicMetriicsDTO: BasicMetriicsDTO::fromApi($analytic),
                    lang: $this->lang,
                    days: $this->days,
                    to: $to->toDateString(),
                    from: $from->toDateString(),
                );

                $pdf = $pdfReportService->generate($context, ReportType::BASIC);
            }

            $safeGroup = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) ($groupDto->findGroup ?? $groupDto->idGroup ?? 'channel'));
            $typePart = $this->type === 'audience' ? 'audience' : 'basic';
            $fileName = "telegram_{$typePart}_{$safeGroup}_{$from->format('Ymd')}_{$to->format('Ymd')}.pdf";
            $filePath = "reports/web/{$this->userId}/{$this->taskId}.pdf";

            Storage::disk('private')->put($filePath, $pdf->output());

            $taskService->markCompleted($this->taskId, $filePath, $fileName);
        } catch (Throwable $exception) {
            $taskService->markFailed($this->taskId, $exception->getMessage());
        }
    }

    private function resolveGroupFilter(string $input): ?array
    {
        $input = trim($input);

        if ($input === '') {
            return null;
        }

        if (preg_match('/^-\d+$/', $input) || preg_match('/^\d+$/', $input)) {
            return ['id_group' => $input];
        }

        if (preg_match('/^@(?<username>[a-zA-Z0-9_]{3,})$/', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        if (preg_match('/^(?<username>[a-zA-Z0-9_]{3,})$/', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        if (preg_match('/(?:https:\/\/)?t\.me\/{1,2}(?<username>[a-zA-Z0-9_]{3,})\/?$/i', $input, $matches)) {
            return ['username' => $matches['username']];
        }

        return null;
    }
}
