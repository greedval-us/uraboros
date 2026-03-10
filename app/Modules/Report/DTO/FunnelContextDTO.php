<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\FunnelDTO;
use App\Modules\Bot\DTO\GroupDTO;


class FunnelContextDTO
{
    public function __construct(
        public GroupDTO $group,
        public FunnelDTO $analytic ,
        public string $lang,
        public int $days,
        public string $to = '',
        public string $from = '',
    ) {}
}
