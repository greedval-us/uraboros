<?php

namespace App\Modules\Bot\Services;

use App\Models\BotUser;
use Carbon\Carbon;

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
}
