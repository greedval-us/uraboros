<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\AudienceQualityDTO;
use App\Modules\Bot\DTO\BasicMetriicsDTO;
use App\Modules\Bot\DTO\FunnelDTO;
use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\DTO\UserLeadersDTO;

class FullReportContextDTO
{
    public function __construct(
        public GroupDTO $group,
        public FunnelDTO $funnelDTO,
        public AudienceQualityDTO $audienceQualityDTO,
        public BasicMetriicsDTO $basicMetriicsDTO,
        public UserLeadersDTO $userLeadersDTO,
        public string $lang,
        public int $days,
        public string $to = '',
        public string $from = '',
    ) {}
}
