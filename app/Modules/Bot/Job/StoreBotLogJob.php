<?php

namespace App\Modules\Bot\Job;

use App\Models\BotLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreBotLogJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly array $payload,
    ) {}

    public function handle(): void
    {
        try {
            BotLog::create($this->sanitize($this->payload));
        } catch (\Throwable $throwable) {
            Log::error('Failed to store bot log entry', [
                'exception' => $throwable,
            ]);
        }
    }

    private function sanitize(array $payload): array
    {
        $allowed = [
            'level',
            'event',
            'action',
            'message',
            'telegram_id',
            'chat_id',
            'message_id',
            'callback_type',
            'context',
            'exception_class',
            'exception_message',
            'exception_code',
            'exception_file',
            'exception_line',
        ];

        $clean = [];
        foreach ($allowed as $key) {
            if (!array_key_exists($key, $payload)) {
                continue;
            }

            $clean[$key] = $payload[$key];
        }

        $clean['level'] = (string) ($clean['level'] ?? 'info');
        $clean['event'] = (string) ($clean['event'] ?? 'action');

        foreach (['action' => 100, 'callback_type' => 100] as $key => $limit) {
            if (!isset($clean[$key])) {
                continue;
            }
            $clean[$key] = $this->truncate((string) $clean[$key], $limit);
        }

        foreach (['message' => 6000, 'exception_message' => 6000] as $key => $limit) {
            if (!isset($clean[$key])) {
                continue;
            }
            $clean[$key] = $this->truncate((string) $clean[$key], $limit);
        }

        if (isset($clean['exception_class'])) {
            $clean['exception_class'] = $this->truncate((string) $clean['exception_class'], 255);
        }

        if (isset($clean['exception_file'])) {
            $clean['exception_file'] = $this->truncate((string) $clean['exception_file'], 255);
        }

        if (isset($clean['chat_id'])) {
            $clean['chat_id'] = $this->truncate((string) $clean['chat_id'], 64);
        }

        foreach (['telegram_id', 'message_id', 'exception_code', 'exception_line'] as $key) {
            if (!isset($clean[$key])) {
                continue;
            }
            $clean[$key] = is_numeric($clean[$key]) ? (int) $clean[$key] : null;
        }

        if (isset($clean['context']) && !is_array($clean['context'])) {
            $clean['context'] = ['value' => (string) $clean['context']];
        }

        if (isset($clean['context']) && is_array($clean['context'])) {
            $encoded = json_encode($clean['context']);
            if ($encoded !== false && strlen($encoded) > 60000) {
                $clean['context'] = [
                    'note' => 'context_too_large',
                    'keys' => array_slice(array_keys($clean['context']), 0, 50),
                ];
            }
        }

        return $clean;
    }

    private function truncate(string $value, int $limit): string
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return mb_substr($value, 0, max(0, $limit - 1)) . '…';
    }
}

