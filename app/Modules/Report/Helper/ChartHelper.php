<?php

namespace App\Modules\Report\Helper;

class ChartHelper
{
    private const MAX_LINE_POINTS = 40;

    public static function line(
        array $data,
        array $fields,
        array $labels,
        array $colors,
        string $title
    ): string {

        // уменьшаем количество точек если их слишком много
        $data = self::downsample($data, self::MAX_LINE_POINTS);

        $datasets = [];
        $maxValue = 0.0;

        foreach ($fields as $i => $field) {
            $series = array_map(
                fn(array $row): float =>
                    round((float)($row[$field] ?? 0), 2),
                $data
            );

            $seriesMax = $series ? max($series) : 0.0;
            $maxValue = max($maxValue, (float)$seriesMax);

            $borderColor = $colors[$i] ?? '#999999';

            $datasets[] = [
                'label' => $labels[$i] ?? $field,
                'data' => $series,
                'borderColor' => $borderColor,
                'backgroundColor' => self::hexToRgba($borderColor, 0.12),
                'fill' => false,
                'tension' => 0.25,
                'borderWidth' => 2,
                'pointRadius' => 2,
                'pointHoverRadius' => 4,
                'pointBorderWidth' => 2,
                'pointBackgroundColor' => '#ffffff',
            ];
        }

        $yTickSuffix = $maxValue <= 100.0 ? '%' : '';

        $config = [
            'type' => 'line',
            'data' => [
                'labels' => array_map(
                    fn(array $row): string => ($row['day'] ?? '?'),
                    $data
                ),
                'datasets' => $datasets,
            ],
            'options' => self::buildOptions(
                title: $title,
                yTickSuffix: $yTickSuffix,
                isCategoryXAxis: true
            ),
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
            $backgroundColor = $colors[$i] ?? '#999999';
            $datasets[] = [
                'label' => $labels[$i] ?? $field,
                'data' => array_map(
                    fn(array $row): float =>
                        round((float)($row[$field] ?? 0), 2),
                    $data
                ),
                'backgroundColor' => self::hexToRgba($backgroundColor, 0.75),
                'borderColor' => $backgroundColor,
                'borderWidth' => 1,
                'borderRadius' => 4,
                'borderSkipped' => false,
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
            'options' => self::buildOptions(
                title: $title,
                yTickSuffix: '',
                isCategoryXAxis: true
            ),
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
                    'backgroundColor' => array_map(
                        fn(string $hex): string => self::hexToRgba($hex, 0.85),
                        $backgroundColors
                    ),
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ]]
            ],
            'options' => self::buildPieOptions($title),
        ];

        return self::quickChartUrl($config);
    }

    private static function buildOptions(string $title, string $yTickSuffix, bool $isCategoryXAxis): array
    {
        $options = [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'devicePixelRatio' => 2,
            'animation' => false,
            'layout' => [
                'padding' => [
                    'top' => 8,
                    'right' => 12,
                    'bottom' => 6,
                    'left' => 12,
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 10,
                        'padding' => 14,
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => $title,
                    'font' => [
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'padding' => [
                        'top' => 6,
                        'bottom' => 10,
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.92)',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#ffffff',
                    'padding' => 10,
                    'cornerRadius' => 6,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'autoSkip' => true,
                        'maxRotation' => 45,
                        'minRotation' => 0,
                        'maxTicksLimit' => 12,
                        'color' => '#334155',
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(148, 163, 184, 0.25)',
                    ],
                    'ticks' => [
                        'color' => '#334155',
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                ],
            ],
        ];

        if ($isCategoryXAxis) {
            $options['scales']['x']['type'] = 'category';
        }

        if ($yTickSuffix !== '') {
            $suffix = addslashes($yTickSuffix);
            $options['scales']['y']['ticks']['callback'] = "function(value){return value + '{$suffix}'}";
        }

        return $options;
    }

    private static function buildPieOptions(string $title): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'devicePixelRatio' => 2,
            'animation' => false,
            'layout' => [
                'padding' => [
                    'top' => 8,
                    'right' => 12,
                    'bottom' => 6,
                    'left' => 12,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 14,
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => $title,
                    'font' => [
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'padding' => [
                        'top' => 6,
                        'bottom' => 10,
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.92)',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#ffffff',
                    'padding' => 10,
                    'cornerRadius' => 6,
                ],
            ],
        ];
    }

    private static function hexToRgba(string $hex, float $alpha): string
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            return 'rgba(153, 153, 153, ' . max(0, min(1, $alpha)) . ')';
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $a = max(0, min(1, $alpha));

        return "rgba({$r}, {$g}, {$b}, {$a})";
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
