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
                'viewRate' => round($metrics['viewRate'] ?? 0, 6) * 100,
                'reactionRate' => round($metrics['reactionRate'] ?? 0, 6) * 100,
                'commentRate' => round($metrics['commentRate'] ?? 0, 6) * 100,
                'erView' => round($metrics['ERview'] ?? 0, 6) * 100,
            ];
        }

        return $rows;
    }
}
