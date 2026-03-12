<?php

namespace App\Modules\Report\Helper;


class ChartHelper
{
    public static function line(
        array $data,
        array $fields,
        array $labels,
        array $colors,
        string $title
    ): string {
        $datasets = [];

        foreach ($fields as $i => $field) {
            $datasets[] = [
                'label' => $labels[$i] ?? $field,
                'data' => array_map(
                    fn(array $row): int => (int) ($row[$field] ?? 0),
                    $data
                ),
                'borderColor' => $colors[$i] ?? '#999999',
                'fill' => false,
            ];
        }

        $config = [
            'type' => 'line',
            'data' => [
                'labels' => array_map(
                    fn(array $row): string => ($row['day'] ?? '?'),
                    $data
                ),
                'datasets' => $datasets,
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true]
                ],
                'plugins' => [
                    'legend' => ['display' => true],
                    'title' => [
                        'display' => true,
                        'text' => $title
                    ]
                ]
            ]
        ];

        return self::quickChartUrl($config);
    }

    /**
     * @param array<int, array{
     *     day: string|int,
     *     [key: string]: int|string|null
     * }> $data
     * @param array<int, string> $fields
     * @param array<int, string> $labels
     * @param array<int, string> $colors
     */
    public static function bar(
        array $data,
        array $fields,
        array $labels,
        array $colors,
        string $title
    ): string {
        $datasets = [];

        foreach ($fields as $i => $field) {
            $datasets[] = [
                'label' => $labels[$i] ?? $field,
                'data' => array_map(
                    fn(array $row): int => (int) ($row[$field] ?? 0),
                    $data
                ),
                'backgroundColor' => $colors[$i] ?? '#999999',
            ];
        }

        $config = [
            'type' => 'bar',
            'data' => [
                'labels' => array_map(
                    fn(array $row): string => ($row['day'] ?? '?'),
                    $data
                ),
                'datasets' => $datasets,
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true]
                ],
                'plugins' => [
                    'legend' => ['display' => true],
                    'title' => [
                        'display' => true,
                        'text' => $title
                    ]
                ]
            ]
        ];

        return self::quickChartUrl($config);
    }

    public static function pie(
        array $data,
        array $fields,
        array $labels,
        array $colors,
        string $title
    ): string {
        // Берем только одно поле value для pie
        $field = $fields[0] ?? 'value';

        $values = array_map(fn($row) => (int)($row[$field] ?? 0), $data);
        $segmentLabels = array_column($data, 'label');
        $backgroundColors = array_slice($colors, 0, count($values));

        $config = [
            'type' => 'pie',
            'data' => [
                'labels' => $segmentLabels,
                'datasets' => [[
                    'data' => $values,
                    'backgroundColor' => $backgroundColors,
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => true],
                    'title' => [
                        'display' => true,
                        'text' => $title
                    ]
                ]
            ]
        ];

        return self::quickChartUrl($config);
    }

    /**
     * @param array<string, mixed> $chartConfig
     */
    private static function quickChartUrl(array $chartConfig): string
    {
        $url = 'https://quickchart.io/chart?width=800&height=400&c='
            . urlencode(json_encode($chartConfig));

        $image = @file_get_contents($url);

        return $image
            ? 'data:image/png;base64,' . base64_encode($image)
            : '';
    }
}
