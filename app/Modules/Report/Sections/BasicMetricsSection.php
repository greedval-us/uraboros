<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;

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
        // === Период ===
        $periodStart = '2026-02-24';
        $periodEnd = '2026-03-03';

        // === Активные пользователи ===
        $totalActive = 55;
        $commenters = 12;
        $reactors = 34;
        $both = 8;

        // Активность по дням (Публикация или реакция / Публикация / Реакция / Публикация и реакция)
        $activityByDay = [
            ['day' => '1', 'total' => 27, 'posts' => 15, 'reactions' => 10, 'both' => 6],
            ['day' => '2', 'total' => 24, 'posts' => 12, 'reactions' => 12, 'both' => 4],
            ['day' => '3', 'total' => 22, 'posts' => 19, 'reactions' => 15, 'both' => 9],
            ['day' => '4', 'total' => 26, 'posts' => 14, 'reactions' => 13, 'both' => 4],
            ['day' => '5', 'total' => 23, 'posts' => 13, 'reactions' => 10, 'both' => 7],
            ['day' => '6', 'total' => 19, 'posts' => 11, 'reactions' => 16, 'both' => 5],
            ['day' => '7', 'total' => 21, 'posts' => 19, 'reactions' => 17, 'both' => 1],
        ];

        // === Частота публикаций ===
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

        // === Средняя вовлеченность ===
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

        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'totalActive' => $totalActive,
            'commenters' => $commenters,
            'reactors' => $reactors,
            'both' => $both,
            'activityByDay' => $activityByDay,
            'totalPosts' => $totalPosts,
            'adminPosts' => $adminPosts,
            'userPosts' => $userPosts,
            'postsByDay' => $postsByDay,
            'avgEngagement' => $avgEngagement,
            'avgPostsPerPost' => $avgPostsPerPost,
            'avgReactionsPerPost' => $avgReactionsPerPost,
            'engagementByDay' => $engagementByDay,
        ];
    }
}
