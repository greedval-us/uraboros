<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\BasicMetricsContextDTO;
use App\Modules\Report\DTO\FullReportContextDTO;
use App\Modules\Report\Helper\ChartHelper;
use App\Modules\Report\Helper\PeriodTableHelper;

class BasicMetricsSection implements PdfSectionContract
{
    public function __construct(
        protected BasicMetricsContextDTO|FullReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.basic-metrics";
    }

    public function data(): array
    {
        $a = $this->context->basicMetriicsDTO;

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

        $participantChanged = PeriodTableHelper::buildParticipantChanged($a->participantChanged);

        $stickinessRatioPeriod = PeriodTableHelper::build($a->stickinessRatioPeriod);

        $stickinessRatioPeriodChart = ChartHelper::line(
            $stickinessRatioPeriod,
            ['total'],
            ['Коэффициент вовлечённости аудитории'],
            ['#ef4444'],
            'Активность пользователей по дням'
        );

        $activityChart = ChartHelper::line(
            $activityByDay,
            ['total','posts','reactions','both'],
            [
                'Публикация или реакция',
                'Публикация',
                'Реакция',
                'Публикация и реакция'
            ],
            ['#ef4444','#3b82f6','#10b981','#f59e0b'],
            'Активность пользователей по дням'
        );

        $postsChart = ChartHelper::bar(
            $postsByDay,
            ['total','admin','users'],
            [
                'Всего публикаций',
                'Администратор',
                'Пользователи'
            ],
            ['#10b981','#ef4444','#3b82f6'],
            'Публикации по дням'
        );

        $engagementChart = ChartHelper::bar(
            $engagementByDay,
            ['engagement','postsPerPost','reactionsPerPost'],
            [
                'Вовлеченность',
                'Комментарии / пост',
                'Реакции / пост'
            ],
            ['#10b981','#3b82f6','#f59e0b'],
            'Средняя вовлеченность по дням'
        );

        $participantChangedChart = ChartHelper::line(
            $participantChanged,
            ['value'],
            [
                'Участники',
            ],
            ['#3b82f6'],
            'Изменения аудитории'
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
            'participantChanged' => $participantChanged,

            'stickinessRatioPeriod' => $stickinessRatioPeriod,
            'stickinessRatioPeriodChart' => $stickinessRatioPeriodChart,

            'postsByDay' => $postsByDay,

            'avgEngagement' => round($a->engagementRate ?? 0, 2),
            'avgPostsPerPost' => round($a->commentsPerPost ?? 0, 2),
            'avgReactionsPerPost' => round($a->reactionsPerPost ?? 0, 2),

            'engagementByDay' => $engagementByDay,

            'activityChart' => $activityChart,
            'postsChart' => $postsChart,
            'engagementChart' => $engagementChart,
            'participantChangedChart' => $participantChangedChart,
        ];
    }
}
