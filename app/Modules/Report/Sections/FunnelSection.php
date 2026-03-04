<?php

namespace App\Modules\Report\Sections;

use App\Modules\Report\Contracts\PdfSectionContract;
use App\Modules\Report\DTO\ReportContextDTO;
use App\Modules\Report\Helper\ChartHelper;

class FunnelSection implements PdfSectionContract
{
    public function __construct(
        protected ReportContextDTO $context
    ) {}

    public function view(): string
    {
        return "pdf.{$this->context->lang}.sections.funnel";
    }

    public function data(): array
    {
        $periodStart = '2026-02-24';
        $periodEnd = '2026-03-03';

        $totalMembers = 120;

        /*
        |--------------------------------------------------------------------------
        | Фейковые посты
        |--------------------------------------------------------------------------
        */

        $posts = [
            ['date' => '2026-02-24', 'author' => 'Admin', 'views' => 90, 'reactions' => 25, 'comments' => 10],
            ['date' => '2026-02-25', 'author' => 'User1', 'views' => 75, 'reactions' => 18, 'comments' => 7],
            ['date' => '2026-02-26', 'author' => 'Admin', 'views' => 110, 'reactions' => 35, 'comments' => 15],
            ['date' => '2026-02-27', 'author' => 'User2', 'views' => 60, 'reactions' => 12, 'comments' => 5],
            ['date' => '2026-02-28', 'author' => 'Admin', 'views' => 95, 'reactions' => 28, 'comments' => 9],
            ['date' => '2026-03-01', 'author' => 'User3', 'views' => 80, 'reactions' => 20, 'comments' => 6],
            ['date' => '2026-03-02', 'author' => 'Admin', 'views' => 105, 'reactions' => 30, 'comments' => 11],
        ];

        /*
        |--------------------------------------------------------------------------
        | Расчёты по каждому посту
        |--------------------------------------------------------------------------
        */

        $reactionRateByPost = [];
        $commentRateByPost = [];
        $erViewByPost = [];
        $viewRateByPost = [];

        $totalViews = 0;
        $totalReactions = 0;
        $totalComments = 0;

        foreach ($posts as $post) {

            $totalViews += $post['views'];
            $totalReactions += $post['reactions'];
            $totalComments += $post['comments'];

            $reactionRate = round(($post['reactions'] / $post['views']) * 100, 2);
            $commentRate = round(($post['comments'] / $post['views']) * 100, 2);
            $erView = round((($post['reactions'] + $post['comments']) / $post['views']) * 100, 2);
            $viewRate = round(($post['views'] / $totalMembers) * 100, 2);

            $reactionRateByPost[] = $post + ['rate' => $reactionRate];
            $commentRateByPost[] = $post + ['rate' => $commentRate];
            $erViewByPost[] = $post + ['rate' => $erView];
            $viewRateByPost[] = $post + ['rate' => $viewRate, 'members' => $totalMembers];
        }

        /*
        |--------------------------------------------------------------------------
        | Расчёты за период
        |--------------------------------------------------------------------------
        */

        $reactionRatePeriod = round(($totalReactions / $totalViews) * 100, 2);
        $commentRatePeriod = round(($totalComments / $totalViews) * 100, 2);
        $erViewPeriod = round((($totalReactions + $totalComments) / $totalViews) * 100, 2);

        $postsCount = count($posts);
        $viewRatePeriod = round(($totalViews / ($postsCount * $totalMembers)) * 100, 2);

        /*
        |--------------------------------------------------------------------------
        | Графики
        |--------------------------------------------------------------------------
        */

        $funnelChart = ChartHelper::line(
            $posts,
            ['views', 'reactions', 'comments'],
            ['Просмотры', 'Реакции', 'Комментарии'],
            '#3b82f6',
            '#10b981',
            'Динамика воронки по дням'
        );

        $reactionRateChart = ChartHelper::line(
            $reactionRateByPost,
            ['rate'],
            ['ReactionRate'],
            '#f59e0b',
            null,
            'Доля реакций по постам'
        );

        $commentRateChart = ChartHelper::line(
            $commentRateByPost,
            ['rate'],
            ['CommentRate'],
            '#ef4444',
            null,
            'Доля комментариев по постам'
        );

        $erViewChart = ChartHelper::line(
            $erViewByPost,
            ['rate'],
            ['ERview'],
            '#10b981',
            null,
            'ERview по постам'
        );

        $viewRateChart = ChartHelper::line(
            $viewRateByPost,
            ['rate'],
            ['ViewRate'],
            '#6366f1',
            null,
            'Охват просмотров по постам'
        );

        return compact(
            'periodStart',
            'periodEnd',
            'totalMembers',
            'totalViews',
            'totalReactions',
            'totalComments',
            'reactionRateByPost',
            'commentRateByPost',
            'erViewByPost',
            'viewRateByPost',
            'reactionRatePeriod',
            'commentRatePeriod',
            'erViewPeriod',
            'viewRatePeriod',
            'funnelChart',
            'reactionRateChart',
            'commentRateChart',
            'erViewChart',
            'viewRateChart'
        );
    }
}
