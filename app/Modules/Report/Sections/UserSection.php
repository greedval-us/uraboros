<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\UserContextDTO;
use App\Modules\Report\Helper\UserTableHelper;

class UserSection implements PdfSectionContract
{
    public function __construct(
        protected UserContextDTO $context,
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.user";
    }

    public function data(): array
    {

        $a = $this->context;

        $periodStart = $this->context->from;
        $periodEnd   = $this->context->to;

        $activityPeriod = UserTableHelper::buildActivityPeriod(
            $a->userAnalytic->activityPeriod,
        );


        return [

        ];
    }
}
