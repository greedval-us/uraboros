<?php

namespace App\Modules\Report\Pdf;

use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Sections\HeaderSection;

class PdfReportService
{
    public function generate(ReportContextDTO $context)
    {
        $builder = new PdfBuilder();

        $builder->addSection(new HeaderSection($context));

        return $builder->build();
    }
}
