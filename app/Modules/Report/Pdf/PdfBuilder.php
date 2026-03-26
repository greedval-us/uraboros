<?php

namespace App\Modules\Report\Pdf;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Modules\Report\Contracts\PdfSectionContract;

class PdfBuilder
{
    protected array $sections = [];

    public function addSection(PdfSectionContract $section): self
    {
        $this->sections[] = $section;
        return $this;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.layout', [
            'sections' => $this->sections,
        ]);

        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'chroot' => realpath(base_path()),
        ]);

        return $pdf;
    }
}

