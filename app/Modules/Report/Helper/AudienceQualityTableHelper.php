<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class AudienceQualityTableHelper
{
    /**
     * Строит массив для графика/таблицы (линейный график).
     * Работает с плоским массивом ['2026-03-04' => 0.2, ...] или массивом массивов.
     */
    public static function build(array $period): array
    {
        $rows = [];

        foreach ($period as $key => $value) {

            if (is_array($value) && !empty($value)) {
                // если это массив, берем ключ первого элемента
                $day = array_key_first($value);
                $val = $value[$day] ?? 0;
            } else {
                // если плоский массив
                $day = $key;
                $val = $value ?? 0;
            }

            if (!$day || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'value' => $val,
            ];
        }

        return $rows;
    }

    /**
     * То же самое, но в процентах
     */
    public static function buildPercent(array $period): array
    {
        $rows = [];

        foreach ($period as $key => $value) {

            if (is_array($value) && !empty($value)) {
                $day = array_key_first($value);
                $val = $value[$day] ?? 0;
            } else {
                $day = $key;
                $val = $value ?? 0;
            }

            if (!$day || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'value' => round($val * 100, 4),
            ];
        }

        return $rows;
    }
}
