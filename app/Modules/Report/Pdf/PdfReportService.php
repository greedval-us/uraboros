<?php

namespace App\Modules\Report\Pdf;

use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Enums\ReportType;

class PdfReportService
{
    public function __construct(
        protected ReportSectionsResolver $resolver
    ) {}

    public function generate(
        ReportContextDTO $context,
        ReportType $type = ReportType::DEFAULT
    ) {
        $builder = new PdfBuilder();

        foreach ($this->resolver->resolve($type, $context) as $section) {
            $builder->addSection($section);
        }

        return $builder->build();
    }
}
