<?php

namespace App\Modules\Bot\DTO;

use Carbon\Carbon;

class ResultAnalyticDto
{
    public function __construct(
        /** @var array<string,int> */
        public array $topAutorsFromMessages,

        /** @var array<string,int> */
        public array $topAutorsFromReactions,

        /** @var array<string,int> */
        public array $topAutorsAll,

        /** @var array<string,array<string,int>> */
        public array $freqMessagesSort,

        /** @var array<string,array<string,int>> */
        public array $freqUsersSort,

        public ?array $membersStart,
        public ?array $membersEnd,

        public ?int $views,
        public ?int $posts,
        public ?int $comments,
        public ?int $messages,
        public ?int $reactions,
        public ?int $participantsCount,
        public ?int $uniqActions,

        public ?float $au,
        public ?float $postsPerDay,
        public ?float $reactionsPerPost,
        public ?float $commentsPerPost,
        public ?float $engagementRate,
        public ?float $reactionRate,
        public ?float $viewRate,
        public ?float $commentRate,
        public ?float $erView,
        public ?float $writerToMembers,
        public ?float $writerShare,
        public ?float $top10Share,
        public ?float $timeBurstIndex,
        public ?float $growthRate,
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            topAutorsFromMessages: $data['topAutorsFromMessages'] ?? [],
            topAutorsFromReactions: $data['topAutorsFromReactions'] ?? [],
            topAutorsAll: $data['topAutorsAll'] ?? [],

            freqMessagesSort: self::mapDateKey($data['freqMessagesSort'] ?? []),
            freqUsersSort: self::mapDateKey($data['freqUsersSort'] ?? []),

            membersStart: isset($data['membersStart'])
                ? $data['membersStart']
                : null,

            membersEnd: isset($data['membersEnd'])
                ? $data['membersEnd']
                : null,

            views: $data['views'] ?? null,
            posts: $data['posts'] ?? null,
            comments: $data['comments'] ?? null,
            messages: $data['messages'] ?? null,
            reactions: $data['reactions'] ?? null,
            participantsCount: $data['participantsCount'] ?? null,
            uniqActions: $data['uniqActions'] ?? null,

            au: isset($data['au']) ? (float) $data['au'] : null,
            postsPerDay: isset($data['postsPerDay']) ? (float) $data['postsPerDay'] : null,
            reactionsPerPost: isset($data['reactionsPerPost']) ? (float) $data['reactionsPerPost'] : null,
            commentsPerPost: isset($data['commentsPerPost']) ? (float) $data['commentsPerPost'] : null,
            engagementRate: isset($data['engagementRate']) ? (float) $data['engagementRate'] : null,
            reactionRate: isset($data['reactionRate']) ? (float) $data['reactionRate'] : null,
            viewRate: isset($data['viewRate']) ? (float) $data['viewRate'] : null,
            commentRate: isset($data['commentRate']) ? (float) $data['commentRate'] : null,
            erView: isset($data['erView']) ? (float) $data['erView'] : null,
            writerToMembers: isset($data['writerToMembers']) ? (float) $data['writerToMembers'] : null,
            writerShare: isset($data['writerShare']) ? (float) $data['writerShare'] : null,
            top10Share: isset($data['top10Share']) ? (float) $data['top10Share'] : null,
            timeBurstIndex: isset($data['timeBurstIndex']) ? (float) $data['timeBurstIndex'] : null,
            growthRate: isset($data['growthRate']) ? (float) $data['growthRate'] : null,
        );
    }

    /**
     * Преобразует Instant (ISO) → string(Carbon)
     */
    private static function mapDateKey(array $data): array
    {
        $result = [];

        foreach ($data as $date => $values) {
            $carbon = Carbon::parse($date)->toISOString();
            $result[$carbon] = $values;
        }

        return $result;
    }
}
