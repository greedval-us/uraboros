<?php

namespace App\Modules\Report\Pdf;

use App\Modules\Report\Enums\ReportType;
use App\Modules\Report\Helpers\EncodingHelper;

class PdfReportService
{
    public function __construct(
        protected ReportSectionsResolver $resolver
    ) {}

    public function generate(
        object $context,
        ReportType $type = ReportType::DEFAULT
    ) {
        // Убеждаемся, что все данные в контексте имеют правильную UTF-8 кодировку
        $context = EncodingHelper::ensureUtf8($context);

        $builder = new PdfBuilder();

        foreach ($this->resolver->resolve($type, $context) as $section) {
            $builder->addSection($section);
        }

        return $builder->build();
    }
}
