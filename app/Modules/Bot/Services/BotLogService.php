<?php

namespace App\Modules\Bot\Services;

use App\Modules\Bot\Job\StoreBotLogJob;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class BotLogService
{
    public function action(
        string $action,
        array $context = [],
        array $meta = [],
        string $level = 'info',
    ): void {
        $this->dispatch([
            'level' => $level,
            'event' => 'action',
            'action' => $action,
            'context' => $context,
            ...$this->onlyMeta($meta),
        ]);
    }

    public function error(
        Throwable $throwable,
        array $context = [],
        array $meta = [],
    ): void {
        $this->dispatch([
            'level' => $throwable instanceof HttpExceptionInterface ? 'warning' : 'error',
            'event' => 'exception',
            'action' => $meta['callback_type'] ?? null,
            'message' => $throwable->getMessage(),
            'context' => array_merge([
                'exception' => [
                    'class' => get_class($throwable),
                    'code' => $throwable->getCode(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                ],
            ], $context),
            'exception_class' => get_class($throwable),
            'exception_message' => $throwable->getMessage(),
            'exception_code' => (int) $throwable->getCode(),
            'exception_file' => $throwable->getFile(),
            'exception_line' => (int) $throwable->getLine(),
            ...$this->onlyMeta($meta),
        ]);
    }

    private function dispatch(array $payload): void
    {
        try {
            StoreBotLogJob::dispatch($payload);
        } catch (Throwable $throwable) {
            Log::error('Failed to dispatch bot log job', [
                'exception' => $throwable,
            ]);
        }
    }

    private function onlyMeta(array $meta): array
    {
        return array_intersect_key($meta, array_flip([
            'telegram_id',
            'chat_id',
            'message_id',
            'callback_type',
        ]));
    }
}

