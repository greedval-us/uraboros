<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;

class RetentionSection implements PdfSectionContract
{
    public function __construct(
        protected ReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.footer";
    }

    public function data(): array
    {
        return [];
    }
}
