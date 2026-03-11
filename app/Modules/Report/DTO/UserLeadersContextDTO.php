<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\DTO\UserLeadersDTO;

class UserLeadersContextDTO
{
    public function __construct(
        public GroupDTO $group,
        public UserLeadersDTO $analytic ,
        public string $lang,
        public int $days,
        public string $to = '',
        public string $from = '',
    ) {}
}
