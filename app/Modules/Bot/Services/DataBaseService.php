<?php

namespace App\Modules\Bot\Services;

use App\Models\BotUser;
use App\Models\ChennelMonitoring;
use DefStudio\Telegraph\DTO\User;
use Illuminate\Database\Eloquent\Collection;

class DataBaseService
{
    public function createUser(User $data, string $payload)
    {
        $referralCode = $this->extractReferralCode($payload);

        /** @var BotUser $user */
        $user = BotUser::firstOrCreate(
            ['telegram_id' => $data->id()],
            [
            'telegram_id'    => $data->id(),
            'username'       => $data->username() ?? null,
            'first_name'     => $data->firstName() ?? null,
            'last_name'      => $data->lastName()?? null,
            'requests'       => 10,
            'count_requests' => 0,
            'last_requests'  => null,
            'premium'        => false,
            'premium_start'  => null,
            'premium_end'    => null,
            'lang'           => 'ru',
            'referral_code'  => BotUser::generateReferralCode(),
            'referred_by'    => $referralCode,
            ]
        );

        $this->updateExistingUser($user, $data);
    }
    public function getUser(int $id): BotUser|null
    {
        $user = BotUser::where('telegram_id', $id)->first();
        return $user;
    }


    public function getFreeRequest(int $id): BotUser
    {
        $user = BotUser::where('telegram_id', $id)->first();
        return $user->activateFreeRequests();
    }

    public function getMyChannels(int $id): Collection
    {
        return ChennelMonitoring::where('telegram_id', $id)->get();
    }
    public function getMyChannel(int $id): ChennelMonitoring
    {
        return ChennelMonitoring::where('id', $id)->first();
    }

    public function deleteMyChannel(int $id, int $idTelegram): bool
    {
        $channel = ChennelMonitoring::where('id', $id)
            ->where('telegram_id', operator: $idTelegram)
            ->first();

        if (!$channel) {
            return false;
        }

        return (bool) $channel->delete();
    }
    public function addChannelMonitoring(int $id, string $chennel, int $limit = 5,): bool
    {
        $count = ChennelMonitoring::where('telegram_id', $id)->count();

        if ($count >= $limit) {
            return false;
        }

        $exists = ChennelMonitoring::where('telegram_id', $id)
            ->where('chennel', $chennel)
            ->exists();

        if ($exists) {
            return false;
        }

        ChennelMonitoring::create([
            'telegram_id' => $id,
            'chennel' => $chennel,
            'last_request' => now(),
        ]);

        return true;
    }

    private function extractReferralCode(string $payload): ?string
    {
        if (empty($payload)) {
            return null;
        }

        BotUser::applyReferralCode((string) $payload);
        return (string) $payload;
    }

    public function canMakeAction(int $telegramId, int $cost = 1): bool
    {
        $user = $this->getUser($telegramId);

        if (!$user) {
            return false;
        }

        return $user->tryConsumeRequest($cost);
    }

    private function updateExistingUser(BotUser $user, User $data): void
    {
        if ($user->wasRecentlyCreated) {
            return;
        }

        $user->update([
            'username'   => $data->username() ?? $user->username,
            'first_name' => $data->firstName() ?? $user->first_name,
            'last_name'  => $data->lastName() ?? $user->last_name,
        ]);
    }
}
