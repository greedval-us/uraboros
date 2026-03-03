<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;

class BasicMetricsSection implements PdfSectionContract
{
    public function __construct(
        protected ReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.basic-metrics";
    }

    public function data(): array
    {
        $analytic = $this->context->analytic;

        return [
            'topMessages' => $this->prepareTop10($analytic->topAutorsFromMessages),
            'topReactions' => $this->prepareTop10($analytic->topAutorsFromReactions),
        ];
    }

    private function prepareTop10(array $data): array
    {
        $result = [];

        foreach (array_slice($data, 0, 10) as $row) {
            foreach ($row as $userId => $count) {
                $result[] = [
                    'user_id' => $userId,
                    'count'   => $count,
                ];
            }
        }

        return $result;
    }
}
