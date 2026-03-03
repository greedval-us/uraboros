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

        $messages  = $this->buildChartBlock($analytic->topAutorsFromMessages, 'Топ 10 • Сообщения');
        $reactions = $this->buildChartBlock($analytic->topAutorsFromReactions, 'Топ 10 • Реакции');
        $all       = $this->buildChartBlock($analytic->topAutorsAll, 'Топ 10 • Вся активность');

        $timeChart = $this->generateLineChart(
            $analytic->freqMessagesSort ?? [],
            $analytic->freqUsersSort ?? [],
            'Активность по времени'
        );

        return [
            'title' => 'Базовые метрики',
            'messages' => $messages,
            'reactions' => $reactions,
            'all' => $all,
            'timeChart' => $timeChart,
        ];
    }

    private function prepareTop10(array $data): array
    {
        $result = [];
        foreach (array_slice($data, 0, 10) as $row) {
            foreach ($row as $userId => $count) {
                $result[] = [
                    'user_id' => $userId,
                    'count' => $count,
                ];
            }
        }
        return $result;
    }

    private function buildChartBlock(array $data, string $title): array
    {
        $top10 = $this->prepareTop10($data);
        if (empty($top10)) return [];

        $topTotal = array_sum(array_column($top10, 'count'));
        $fullTotal = 0;
        foreach ($data as $row) $fullTotal += (int) reset($row);

        $colors = [
            '#D4AF37','#C0C0C0','#CD7F32','#3b82f6','#10b981',
            '#8b5cf6','#ef4444','#f59e0b','#6366f1','#14b8a6'
        ];

        foreach ($top10 as $i => &$item) {
            $item['rank'] = $i + 1;
            $item['percent'] = $topTotal > 0 ? round($item['count'] / $topTotal * 100, 1) : 0;
            $item['color'] = $colors[$i] ?? '#999999';
        }
        unset($item);

        $share = $fullTotal > 0 ? round($topTotal / $fullTotal * 100, 1) : 0;

        return [
            'title' => $title,
            'chart' => $this->generatePieChart($top10, $title),
            'table' => $top10,
            'share' => $share,
        ];
    }

    private function generatePieChart(array $data, string $title): string
    {
        $labels = array_map(fn($i) => '#' . $i['rank'] . ' ID ' . $i['user_id'], $data);
        $values = array_column($data, 'count');
        $colors = array_column($data, 'color');

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [['data' => $values, 'backgroundColor' => $colors]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => false],
                    'title' => ['display' => true, 'text' => $title, 'font' => ['size' => 20]]
                ]
            ]
        ];

        $url = 'https://quickchart.io/chart?width=800&height=500&format=png&c='
             . urlencode(json_encode($chartConfig));

        $image = file_get_contents($url);
        return 'data:image/png;base64,' . base64_encode($image);
    }

    private function generateLineChart(array $freqMessages, array $freqUsers, string $title): string
    {
        $labels = array_keys($freqMessages);
        $messages = array_map(fn($v) => array_sum($v), $freqMessages);
        $users = array_map(fn($v) => count($v), $freqUsers);

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Сообщения',
                        'data' => $messages,
                        'borderColor' => '#3b82f6',
                        'fill' => false
                    ],
                    [
                        'label' => 'Активные участники',
                        'data' => $users,
                        'borderColor' => '#10b981',
                        'fill' => false
                    ]
                ]
            ],
            'options' => [
                'plugins' => [
                    'title' => ['display' => true, 'text' => $title, 'font' => ['size' => 16]]
                ],
                'scales' => [
                    'x' => ['title' => ['display' => true, 'text' => 'Время']],
                    'y' => ['title' => ['display' => true, 'text' => 'Количество']]
                ]
            ]
        ];

        $url = 'https://quickchart.io/chart?width=800&height=400&format=png&c='
             . urlencode(json_encode($chartConfig));

        $image = file_get_contents($url);
        return 'data:image/png;base64,' . base64_encode($image);
    }
}
