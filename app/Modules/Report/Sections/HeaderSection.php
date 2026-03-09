<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;

class HeaderSection implements PdfSectionContract
{
    public function __construct(
        protected object $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.header";
    }

    public function data(): array
    {
        return [
            'date'  => now()->format('d.m.Y'),
        ];
    }
}
