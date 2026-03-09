<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;

class FooterSection implements PdfSectionContract
{
    public function __construct(
        protected object $context
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
