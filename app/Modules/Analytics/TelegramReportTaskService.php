<?php

namespace App\Modules\Analytics;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TelegramReportTaskService
{
    private const TTL_SECONDS = 7200;

    public function create(int $userId, string $target, int $days, string $type): array
    {
        $taskId = (string) Str::uuid();

        $payload = [
            'taskId' => $taskId,
            'userId' => $userId,
            'target' => $target,
            'days' => $days,
            'type' => $type,
            'status' => 'queued',
            'message' => 'Задача поставлена в очередь.',
            'filePath' => null,
            'fileName' => null,
            'createdAt' => now()->toIso8601String(),
            'updatedAt' => now()->toIso8601String(),
        ];

        Cache::put($this->key($taskId), $payload, self::TTL_SECONDS);

        return $payload;
    }

    public function find(string $taskId): ?array
    {
        $task = Cache::get($this->key($taskId));

        return is_array($task) ? $task : null;
    }

    public function markProcessing(string $taskId, string $message = 'Отчет формируется...'): void
    {
        $this->update($taskId, [
            'status' => 'processing',
            'message' => $message,
        ]);
    }

    public function markCompleted(string $taskId, string $filePath, string $fileName): void
    {
        $this->update($taskId, [
            'status' => 'completed',
            'message' => 'Отчет готов.',
            'filePath' => $filePath,
            'fileName' => $fileName,
        ]);
    }

    public function markFailed(string $taskId, string $message): void
    {
        $this->update($taskId, [
            'status' => 'failed',
            'message' => $message,
        ]);
    }

    private function update(string $taskId, array $updates): void
    {
        $task = $this->find($taskId);

        if ($task === null) {
            return;
        }

        $task = array_merge($task, $updates, [
            'updatedAt' => now()->toIso8601String(),
        ]);

        Cache::put($this->key($taskId), $task, self::TTL_SECONDS);
    }

    private function key(string $taskId): string
    {
        return "telegram_report_task:{$taskId}";
    }
}
