<?php

namespace App\Modules\Report\Helper;

use Carbon\Carbon;

class PeriodTableHelper
{
    public static function build(array $base, array $extra = []): array
    {
        $rows = [];

        foreach ($base as $date => $value) {

            $row = [
                'day' => Carbon::parse($date)->format('d.m'),
                'total' => $value
            ];

            foreach ($extra as $key => $source) {
                $row[$key] = $source[$date] ?? 0;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public static function buildParticipantChanged(array $data): array
    {
        $rows = [];

        foreach ($data as $datetime => $value) {

            $rows[] = [
                'day' => Carbon::parse($datetime)->format('d.m.Y H:i:s'),
                'value' => $value,
            ];
        }

        return $rows;
    }

    public static function buildEngagement(
        array $engagement,
        array $commentsPerPost,
        array $reactionsPerPost
    ): array {

        $rows = [];

        foreach ($engagement as $date => $value) {

            $rows[] = [
                'day' => Carbon::parse($date)->format('d.m'),
                'engagement' => round($value, 2),
                'postsPerPost' => round($commentsPerPost[$date] ?? 0, 2),
                'reactionsPerPost' => round($reactionsPerPost[$date] ?? 0, 2),
            ];
        }

        return $rows;
    }
}
