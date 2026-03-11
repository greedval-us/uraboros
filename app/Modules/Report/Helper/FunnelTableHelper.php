<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class FunnelTableHelper
{
    public static function build(array $ERperDay): array
    {
        $rows = [];

        foreach ($ERperDay as $item) {

            if (!is_array($item)) {
                continue;
            }

            foreach ($item as $date => $metrics) {

                if (!is_array($metrics)) {
                    continue;
                }

                $rows[] = [
                    'day' => Carbon::createFromFormat('Y-m-d', $date)->format('d.m'),

                    'viewRate' => round(($metrics['viewRate'] ?? 0) * 100, 2),
                    'reactionRate' => round(($metrics['reactionRate'] ?? 0) * 100, 2),
                    'commentRate' => round(($metrics['commentRate'] ?? 0) * 100, 2),
                    'erView' => round(($metrics['ERview'] ?? 0) * 100, 2),
                ];
            }
        }

        return $rows;
    }
}
