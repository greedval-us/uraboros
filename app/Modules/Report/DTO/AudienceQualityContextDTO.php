<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\AudienceQualityDTO;
use App\Modules\Bot\DTO\GroupDTO;


class AudienceQualityContextDTO
{
    public function __construct(
        public GroupDTO $group,
        public AudienceQualityDTO $audienceQualityDTO,
        public string $lang,
        public int $days,
        public string $to = '',
        public string $from = '',
    ) {}
}
