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

        $messages = $this->prepareTop10($analytic->topAutorsFromMessages);
        $reactions = $this->prepareTop10($analytic->topAutorsFromReactions);
        $all = $this->prepareTop10($analytic->topAutorsAll);

        return [
            'messagesChart'  => $this->generatePieChart($messages, 'Top 10 • Messages'),
            'reactionsChart' => $this->generatePieChart($reactions, 'Top 10 • Reactions'),
            'allChart'       => $this->generatePieChart($all, 'Top 10 • All Activity'),
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

    private function generatePieChart(array $data, string $title): string
    {
        if (empty($data)) {
            return '';
        }

        $labels = array_map(fn($i) => 'ID ' . $i['user_id'], $data);
        $values = array_map(fn($i) => $i['count'], $data);

        $chartConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $values,
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'right',
                        'labels' => [
                            'boxWidth' => 12
                        ]
                    ],
                    'title' => [
                        'display' => true,
                        'text' => $title,
                        'font' => [
                            'size' => 18
                        ]
                    ]
                ]
            ]
        ];

        $url = 'https://quickchart.io/chart?width=600&height=400&c='
            . urlencode(json_encode($chartConfig));

        $image = file_get_contents($url);

        return 'data:image/png;base64,' . base64_encode($image);
    }
}
