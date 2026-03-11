<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class FunnelTableHelper
{
    public static function build(array $ERperDay): array
    {
        $rows = [];

        foreach ($ERperDay as $row) {

            $date = array_key_first($row);
            $data = $row[$date];

            $rows[] = [
                'day' => Carbon::parse($date)->format('d.m'),

                'viewRate' => round(($data['viewRate'] ?? 0) * 100, 2),
                'reactionRate' => round(($data['reactionRate'] ?? 0) * 100, 2),
                'commentRate' => round(($data['commentRate'] ?? 0) * 100, 2),
                'erView' => round(($data['ERview'] ?? 0) * 100, 2),
            ];
        }

        return $rows;
    }
}
