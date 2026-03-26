<?php

namespace App\Modules\Report\Pdf;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\Helpers\EncodingHelper;

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
        // Обрабатываем данные каждой секции для обеспечения правильной кодировки UTF-8
        $sectionsData = array_map(function (PdfSectionContract $section) {
            $sectionData = $section->data();
            // Убеждаемся, что все данные секции имеют правильную кодировку
            return EncodingHelper::ensureUtf8($sectionData);
        }, $this->sections);

        return Pdf::loadView('pdf.layout', [
            'sections' => $this->sections,
        ]);
    }
}

