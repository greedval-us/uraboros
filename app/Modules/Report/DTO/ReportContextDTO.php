<?php

namespace App\Modules\Report\DTO;

use App\Modules\Bot\DTO\GroupDTO;
use App\Modules\Bot\DTO\AnalyticDTO;

class ReportContextDTO
{
    public function __construct(
        public GroupDTO $group,
        public AnalyticDTO $analytic,
        public string $lang,
        public int $days,
    ) {}
}
