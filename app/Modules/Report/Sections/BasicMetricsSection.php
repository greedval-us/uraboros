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
        $analytic = $this->context->analytic;

        $periodStart = $analytic->periodStart ?? null;
        $periodEnd = $analytic->periodEnd ?? null;

        $totalActive = $analytic->totalActive ?? 0;
        $commenters = $analytic->commenters ?? 0;
        $reactors = $analytic->reactors ?? 0;
        $both = $analytic->both ?? 0;
        $activityByDay = $analytic->activityByDay ?? [];

        $totalPosts = $analytic->totalPosts ?? 0;
        $adminPosts = $analytic->adminPosts ?? 0;
        $userPosts = $analytic->userPosts ?? 0;
        $postsByDay = $analytic->postsByDay ?? [];

        $avgEngagement = $analytic->avgEngagement ?? 0;
        $avgPostsPerPost = $analytic->avgPostsPerPost ?? 0;
        $avgReactionsPerPost = $analytic->avgReactionsPerPost ?? 0;
        $engagementByDay = $analytic->engagementByDay ?? [];

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
