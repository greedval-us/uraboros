<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\ChangedUserDTO;
use App\Modules\Bot\DTO\UserAnalyticsDTO;
use App\Modules\Bot\DTO\UserDTO;

class UserContextDTO
{
    public function __construct(
        public UserDTO $user,
        public UserAnalyticsDTO $userAnalytic,
        public array $changedUser,
        public string $lang,
        public int $days,
        public string $to = '',
        public string $from = '',
    ) {}
}
