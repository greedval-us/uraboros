<?php

namespace App\Modules\Report\Contracts;

interface PdfSectionContract
{
    public function view(): string;

    public function data(): array;
}
