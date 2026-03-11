<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class AudienceQualityTableHelper
{
    /**
     * Для индекса временных всплесков
     */
    public static function build(array $period): array
    {
        $rows = [];

        foreach ($period as $day => $value) {
            if (!$day || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $day)) {
                continue;
            }

            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'value' => round(($value  ?? 0), 6),
            ];
        }

        return $rows;
    }
}
