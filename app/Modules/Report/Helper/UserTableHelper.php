<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class UserTableHelper
{
    public static function buildActivityPeriod(array $period): array
    {
        $rows = [];

        foreach ($period as $day => $value) {
            $rows[] = [
                'day' => Carbon::parse($day)->format('d.m'),
                'allGifts' => $value['allGifts'] ?? 0,
                'allMessages' => $value['allMessages'] ?? 0,
                'allReactions' => $value['allReactions'] ?? 0,
            ];
        }

        return $rows;
    }

    public static function buildActivityByGroups(array $period): array
    {
        $rows = [];

        foreach ($period as $day => $value) {
            $rows[] = [
                'day' => $day,
                'allGifts' => $value['allGifts'] ?? 0,
                'allMessages' => $value['allMessages'] ?? 0,
                'allReactions' => $value['allReactions'] ?? 0,
            ];
        }

        return $rows;
    }
}
