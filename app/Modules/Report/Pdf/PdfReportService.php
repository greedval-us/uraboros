<?php

namespace App\Modules\Report\Pdf;

use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Sections\BasicMetricsSection;
use App\Modules\Report\Sections\GroupInfoSection;
use App\Modules\Report\Sections\HeaderSection;

class PdfReportService
{
    public function generate(ReportContextDTO $context)
    {
        $builder = new PdfBuilder();

        $builder->addSection(new HeaderSection($context))
                ->addSection(new GroupInfoSection($context))
                ->addSection(new BasicMetricsSection($context));
        return $builder->build();
    }
}
