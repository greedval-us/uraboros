<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;

class ba implements PdfSectionContract
{
    public function __construct(
        protected object $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.basic-metrics";
    }

    public function data(): array
    {
        $analytic = $this->context->analytic;

        return [
            'messages'  => $this->buildChartBlock(
                $analytic->topAutorsFromMessages,
                'Топ 10 • Сообщения'
            ),

            'reactions' => $this->buildChartBlock(
                $analytic->topAutorsFromReactions,
                'Топ 10 • Реакции'
            ),

            'all'       => $this->buildChartBlock(
                $analytic->topAutorsAll,
                'Топ 10 • Вся активность'
            ),
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

    private function buildChartBlock(array $data, string $title): array
    {
        $top10 = $this->prepareTop10($data);

        if (empty($top10)) {
            return [];
        }

        $topTotal = 0;
        foreach ($top10 as $item) {
            $topTotal += (int) $item['count'];
        }

        $fullTotal = 0;
        foreach ($data as $row) {
            $fullTotal += (int) reset($row);
        }

        $colors = [
            '#D4AF37',
            '#C0C0C0',
            '#CD7F32',
            '#3b82f6',
            '#10b981',
            '#8b5cf6',
            '#ef4444',
            '#f59e0b',
            '#6366f1',
            '#14b8a6',
        ];

        foreach ($top10 as $index => &$item) {
            $item['rank'] = $index + 1;
            $item['percent'] = $topTotal > 0
                ? round($item['count'] / $topTotal * 100, 1)
                : 0;

            $item['color'] = $colors[$index] ?? '#999999';
        }
        unset($item);

        $share = $fullTotal > 0
            ? round($topTotal / $fullTotal * 100, 1)
            : 0;

        return [
            'title' => $title,
            'chart' => $this->generatePieChart($top10, $title),
            'table' => $top10,
            'share' => $share,
        ];
    }

    private function generatePieChart(array $data, string $title): string
    {
        $labels = array_map(
            fn($i) => '#' . $i['rank'] . ' ID ' . $i['user_id'],
            $data
        );

        $values = array_column($data, 'count');
        $colors = array_column($data, 'color');

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $values,
                    'backgroundColor' => $colors,
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => false,
                    'title' => [
                        'display' => true,
                        'text' => $title,
                        'font' => ['size' => 20]
                    ]
                ]
            ]
        ];

        $url = 'https://quickchart.io/chart?width=800&height=500&format=png&c='
            . urlencode(json_encode($chartConfig));

        $image = file_get_contents($url);

        return 'data:image/png;base64,' . base64_encode($image);
    }
}
