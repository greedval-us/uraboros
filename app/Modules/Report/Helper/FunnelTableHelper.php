<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class FunnelTableHelper
{
    public static function build(array $ERperDay): array
    {
        $rows = [];

        foreach ($ERperDay as $date => $metrics) {

            if (!is_array($metrics) || empty($metrics)) {
                continue;
            }

            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($date)->format('d.m'),
                'viewRate' => round($metrics['viewRate'] ?? 0, 6),
                'reactionRate' => round($metrics['reactionRate'] ?? 0, 6),
                'commentRate' => round($metrics['commentRate'] ?? 0, 6),
                'erView' => round($metrics['ERview'] ?? 0, 6),
            ];
        }

        return $rows;
    }

    public static function buildRate(array $rate): array
    {
        $rows = [];

        foreach ($rate as $date => $metrics) {

            if (empty($metrics)) {
                continue;
            }

            $rows[] = [
                'day' => $date,
                'value' => round($metrics, 6),
            ];
        }

        return $rows;
    }
}
