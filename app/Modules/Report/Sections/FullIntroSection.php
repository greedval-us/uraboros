<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;

class FullIntroSection implements PdfSectionContract
{
    public function __construct(
        protected object $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.intro-all";
    }

    public function data(): array
    {
        return [];
    }
}
