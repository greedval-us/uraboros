<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\BasicMetricsContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\PeriodTableHelper;

class BasicMetricsSection implements PdfSectionContract
{
    public function __construct(
        protected BasicMetricsContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.basic-metrics";
    }

    public function data(): array
    {
        $a = $this->context->analytic;

        $periodStart = $this->context->from;
        $periodEnd   = $this->context->to;

        $activityByDay = PeriodTableHelper::build(
            $a->allActiveUsersPeriod,
            [
                'posts' => $a->activeUsersPerCommentsPeriod,
                'reactions' => $a->activeUsersPerReactionsPeriod,
                'both' => $a->activeUsersPerCommAndReactPeriod,
            ]
        );

        $postsByDay = PeriodTableHelper::build(
            $a->allPublicationsPeriod,
            [
                'admin' => $a->publicationsFromAdminPeriod,
                'users' => $a->publicationsFromUserPeriod,
            ]
        );

        $engagementByDay = PeriodTableHelper::buildEngagement(
            $a->engagementRatePeriod,
            $a->commentsPerPostPeriod,
            $a->reactionsPerPostPeriod
        );

        $activityChart = ChartHelper::line(
            $activityByDay,
            ['posts','reactions'],
            ['Публикации','Реакции'],
            '#3b82f6',
            '#10b981',
            'Активность пользователей по дням'
        );

        $postsChart = ChartHelper::bar(
            $postsByDay,
            ['admin','users'],
            ['Администратор','Пользователи'],
            ['#ef4444','#3b82f6'],
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

        return [
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,

            'totalActive' => $a->allActiveUsers,
            'commenters' => $a->activeUsersPerComments,
            'reactors' => $a->activeUsersPerReactions,
            'both' => $a->activeUsersPerCommentsAndReactions,

            'activityByDay' => $activityByDay,

            'totalPosts' => $a->allPublications,
            'adminPosts' => $a->publicationsFromAdmin,
            'userPosts' => $a->publicationsFromUser,

            'postsByDay' => $postsByDay,

            'avgEngagement' => round($a->engagementRate ?? 0, 2),
            'avgPostsPerPost' => round($a->commentsPerPost ?? 0, 2),
            'avgReactionsPerPost' => round($a->reactionsPerPost ?? 0, 2),

            'engagementByDay' => $engagementByDay,

            'activityChart' => $activityChart,
            'postsChart' => $postsChart,
            'engagementChart' => $engagementChart,
        ];
    }
}
