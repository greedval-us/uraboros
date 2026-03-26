<?php

namespace App\Modules\Bot\Services;

use App\Modules\Bot\DTO\GroupDTO;
use App\Models\BotUser;
use App\Models\ChennelMonitoring;
use App\Modules\Bot\DTO\UserDTO;
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

    public function getStatsData(BotUser $user, int $channelsCount): array
    {
        return [
            'total_requests' => $user->count_requests,
            'available_requests' => $user->requests,
            'channels_count' => $channelsCount,
            'referrals_count' => $user->referral_count,
            'last_request_at' => optional($user->last_request_at)?->format('d.m.Y H:i') ?? '-',
        ];
    }

    public function getGroupTitleData(GroupDTO $group): array
    {
        return [
            'id' => $group->idGroup,
            'title' => $group->titleGroup ?? 'Без названия',
            'participants' => $group->participantsCount ?? 0,
            'type' => $group->type == 0 ? 'Chat' : 'Channel',
            'created' => $group->createdDate?->format('d.m.Y'),
        ];
    }
    public function getUserTitleData(UserDTO $user): array
    {
        return [
            'id_user' => $user->idUser,
            'first_name' => $user->firstName ?? '',
            'last_name' => $user->lastName ?? '',
            'username' => $user->username ?? '—',
            'about' => $user->about ?? '—',
            'birthday' => $user->birthday
                ? Carbon::parse($user->birthday)->format('d.m.Y')
                : '',
        ];
    }
    public function getMessagesData(string $messages): array
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
