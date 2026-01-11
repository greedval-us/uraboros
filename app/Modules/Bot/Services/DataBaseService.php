<?php

namespace App\Modules\Bot\Services;

use App\Models\BotUser;
use DefStudio\Telegraph\DTO\User;

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

    private function extractReferralCode(string $payload): ?string
    {
        if (empty($payload)) {
            return null;
        }

        BotUser::applyReferralCode((string) $payload);
        return (string) $payload;
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
