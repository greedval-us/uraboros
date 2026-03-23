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

        // уменьшаем количество точек если их слишком много
        $data = self::downsample($data, 40);

        $datasets = [];

        foreach ($fields as $i => $field) {
            $datasets[] = [
                'label' => $labels[$i] ?? $field,
                'data' => array_map(
                    fn(array $row): float =>
                        round((float)($row[$field] ?? 0), 2),
                    $data
                ),
                'borderColor' => $colors[$i] ?? '#999999',
                'fill' => false,
                'tension' => 0.3
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
                'elements' => [
                    'point' => [
                        'radius' => 2
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'callback' => "function(value){return value + '%'}"
                        ]
                    ]
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
                    fn(array $row): float =>
                        round((float)($row[$field] ?? 0), 2),
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

        $field = $fields[0] ?? 'value';

        $values = array_map(
            fn($row) => (float)($row[$field] ?? 0),
            $data
        );

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
     * Уменьшает количество точек на графике
     */
    private static function downsample(array $data, int $maxPoints): array
    {
        $count = count($data);

        if ($count <= $maxPoints) {
            return $data;
        }

        $step = ceil($count / $maxPoints);

        return array_values(array_filter(
            $data,
            fn($_, $i) => $i % $step === 0,
            ARRAY_FILTER_USE_BOTH
        ));
    }

    /**
     * Генерация графика через QuickChart
     */
    private static function quickChartUrl(array $chartConfig): string
    {
        $url = 'https://quickchart.io/chart?width=900&height=420&c='
            . urlencode(json_encode($chartConfig));

        $image = @file_get_contents($url);

        return $image
            ? 'data:image/png;base64,' . base64_encode($image)
            : '';
    }
}
