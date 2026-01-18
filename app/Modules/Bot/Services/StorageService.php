<?php

namespace App\Modules\Bot\Services;

use App\Modules\Bot\Enums\StorageKey;
use DefStudio\Telegraph\Models\TelegraphChat;

class StorageService
{
    public function set(TelegraphChat $chat, string $key, mixed $value): void
    {
        $chat->storage()->set($key, $value);
    }

    public function get(TelegraphChat $chat, string $key, mixed $default = null): mixed
    {
        return $chat->storage()->get($key, $default);
    }

    public function forget(TelegraphChat $chat, string $key): void
    {
        $chat->storage()->forget($key);
    }

    public function setMany(TelegraphChat $chat, array $data): void
    {
        foreach ($data as $key => $value) {
            $chat->storage()->set($key, $value);
        }
    }

    public function setStep(TelegraphChat $chat, string $step): void
    {
        $this->set($chat, StorageKey::STEP->value, $step);
    }

    public function getStep(TelegraphChat $chat): ?string
    {
        return $this->get($chat, StorageKey::STEP->value);
    }

    public function clearStep(TelegraphChat $chat): void
    {
        $this->forget($chat, StorageKey::STEP->value);
    }
}
