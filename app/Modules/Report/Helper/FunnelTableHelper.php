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

                    'viewRate' => $metrics['viewRate'] ?? 0,
                    'reactionRate' => $metrics['reactionRate'] ?? 0,
                    'commentRate' => $metrics['commentRate'] ?? 0,
                    'erView' => $metrics['ERview'] ?? 0,
                ];
            }
        }

        return $rows;
    }
}
