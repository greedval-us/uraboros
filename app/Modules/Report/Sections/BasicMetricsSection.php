<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Helper\ChartHelper;

class BasicMetricsSection implements PdfSectionContract
{
    public function __construct(
        protected ReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.basic-metrics";
    }

    public function data(): array
    {
        $periodStart = '2026-02-24';
        $periodEnd = '2026-03-03';

        $totalActive = 55;
        $commenters = 12;
        $reactors = 34;
        $both = 8;

        $activityByDay = [
            ['day' => '1', 'total' => 27, 'posts' => 15, 'reactions' => 10, 'both' => 6],
            ['day' => '2', 'total' => 24, 'posts' => 12, 'reactions' => 12, 'both' => 4],
            ['day' => '3', 'total' => 22, 'posts' => 19, 'reactions' => 15, 'both' => 9],
            ['day' => '4', 'total' => 26, 'posts' => 14, 'reactions' => 13, 'both' => 4],
            ['day' => '5', 'total' => 23, 'posts' => 13, 'reactions' => 10, 'both' => 7],
            ['day' => '6', 'total' => 19, 'posts' => 11, 'reactions' => 16, 'both' => 5],
            ['day' => '7', 'total' => 21, 'posts' => 19, 'reactions' => 17, 'both' => 1],
        ];

        $totalPosts = 186;
        $adminPosts = 48;
        $userPosts = 138;

        $postsByDay = [
            ['day' => '1', 'total' => 20, 'admin' => 5, 'users' => 15],
            ['day' => '2', 'total' => 15, 'admin' => 3, 'users' => 12],
            ['day' => '3', 'total' => 16, 'admin' => 4, 'users' => 12],
            ['day' => '4', 'total' => 34, 'admin' => 7, 'users' => 27],
            ['day' => '5', 'total' => 21, 'admin' => 5, 'users' => 16],
            ['day' => '6', 'total' => 43, 'admin' => 12, 'users' => 31],
            ['day' => '7', 'total' => 37, 'admin' => 17, 'users' => 20],
        ];

        $avgEngagement = 6;
        $avgPostsPerPost = 5;
        $avgReactionsPerPost = 5;

        $engagementByDay = [
            ['day' => '1', 'engagement' => 5, 'postsPerPost' => 3, 'reactionsPerPost' => 2],
            ['day' => '2', 'engagement' => 6, 'postsPerPost' => 2, 'reactionsPerPost' => 4],
            ['day' => '3', 'engagement' => 8, 'postsPerPost' => 4, 'reactionsPerPost' => 5],
            ['day' => '4', 'engagement' => 5, 'postsPerPost' => 6, 'reactionsPerPost' => 6],
            ['day' => '5', 'engagement' => 8, 'postsPerPost' => 7, 'reactionsPerPost' => 8],
            ['day' => '6', 'engagement' => 5, 'postsPerPost' => 9, 'reactionsPerPost' => 9],
            ['day' => '7', 'engagement' => 7, 'postsPerPost' => 6, 'reactionsPerPost' => 5],
        ];

        $activityChart = ChartHelper::line(
            $activityByDay,
            ['posts', 'reactions'],
            ['Публикации', 'Реакции'],
            '#3b82f6',
            '#10b981',
            'Активность пользователей по дням'
        );

        $postsChart = ChartHelper::bar(
            $postsByDay,
            ['admin', 'users'],
            ['Администратор', 'Пользователи'],
            ['#ef4444', '#3b82f6'],
            'Публикации по дням'
        );

        $engagementChart = ChartHelper::line(
            $engagementByDay,
            ['engagement'],
            ['Вовлеченность'],
            '#10b981',
            null,
            'Средняя вовлеченность по дням'
        );

        return compact(
            'periodStart','periodEnd','totalActive','commenters','reactors','both','activityByDay',
            'totalPosts','adminPosts','userPosts','postsByDay',
            'avgEngagement','avgPostsPerPost','avgReactionsPerPost','engagementByDay',
            'activityChart','postsChart','engagementChart'
        );
    }
}
