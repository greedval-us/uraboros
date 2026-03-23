<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\UserContextDTO;

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

        return [

        ];
    }
}
