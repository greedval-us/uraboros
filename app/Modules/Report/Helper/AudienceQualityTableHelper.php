<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class AudienceQualityTableHelper
{
    public static function build(array $period): array
    {
        $rows = [];

        foreach ($period as $row) {

            if (!is_array($row) || empty($row)) {
                continue;
            }

            $day = array_key_first($row);

            if (!$day || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'value' => $row[$day] ?? 0,
            ];
        }

        return $rows;
    }

    public static function buildPercent(array $period): array
    {
        $rows = [];

        foreach ($period as $row) {

            if (!is_array($row) || empty($row)) {
                continue;
            }

            $day = array_key_first($row);

            if (!$day || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'value' => round(($row[$day] ?? 0) * 100, 4),
            ];
        }

        return $rows;
    }
}
