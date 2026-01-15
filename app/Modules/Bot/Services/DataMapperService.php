<?php

namespace App\Modules\Bot\Services;

use App\Models\BotUser;
use App\Models\ChennelMonitoring;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DataMapperService
{
    public function getProfileData(BotUser $user): array
    {
        $now = Carbon::now();

        $nextActivation = $user->free_requests_reset_at ? $user->free_requests_reset_at->copy()->addDay() : null;

        $freeAvailable = is_null($nextActivation) || $nextActivation->lessThanOrEqualTo($now);

        return [
            'id' => $user->telegram_id,
            'requests' => $user->requests,
            'premium' => $user->premium ? '✅' : '❌',
            'end' => optional($user->premium_end)?->format('d.m.Y'),
            'free_requests' => $freeAvailable ? '✅' : '❌',
            'time' => $freeAvailable ? '—' : $now->diff($nextActivation)->format('%H:%I'),
        ];
    }

    public function getMessagesData(string $messages)
    {
        return [
            'message' => $messages,
        ];
    }

    public function getMyChannelData(ChennelMonitoring $channel): array
    {
        return [
            'name' => $channel->chennel,
            'request' => $channel->last_request,
        ];
    }

    public function getKeyboardData(Collection $keyboard): array
    {
        return $keyboard->mapWithKeys(function ($item) {
            return [$item->id => $item->chennel];
        })->toArray();
    }
}
