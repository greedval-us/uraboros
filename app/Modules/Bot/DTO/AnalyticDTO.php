<?php

namespace App\Modules\Bot\DTO;

use Carbon\Carbon;

class AnalyticDTO
{
    public function __construct(
        public array $topAutorsFromMessages = [],
        public array $topAutorsFromReactions = [],
        public array $topAutorsAll = [],
        public array $freqMessagesSort = [],
        public array $freqUsersSort = [],
        public ?array $membersStart = null,
        public ?array $membersEnd = null,
        public ?int $views = null,
        public ?int $posts = null,
        public ?int $comments = null,
        public ?int $messages = null,
        public ?int $reactions = null,
        public ?int $participantsCount = null,
        public ?int $uniqActions = null,
        public ?float $au = null,
        public ?float $postsPerDay = null,
        public ?float $reactionsPerPost = null,
        public ?float $commentsPerPost = null,
        public ?float $engagementRate = null,
        public ?float $reactionRate = null,
        public ?float $viewRate = null,
        public ?float $commentRate = null,
        public ?float $erView = null,
        public ?float $writerToMembers = null,
        public ?float $writerShare = null,
        public ?float $top10Share = null,
        public ?float $timeBurstIndex = null,
        public ?float $growthRate = null,
    ) {}

    /**
     * Создает DTO из массива данных API
     */
    public static function fromApi(array $data): self
    {
        return new self(
            topAutorsFromMessages: $data['topAutorsFromMessages'] ?? [],
            topAutorsFromReactions: $data['topAutorsFromReactions'] ?? [],
            topAutorsAll: $data['topAutorsAll'] ?? [],
            freqMessagesSort: self::mapDateKey($data['freqMessagesSort'] ?? []),
            freqUsersSort: self::mapDateKey($data['freqUsersSort'] ?? []),
            membersStart: $data['membersStart'] ?? null,
            membersEnd: $data['membersEnd'] ?? null,
            views: $data['views'] ?? null,
            posts: $data['posts'] ?? null,
            comments: $data['comments'] ?? null,
            messages: $data['messages'] ?? null,
            reactions: $data['reactions'] ?? null,
            participantsCount: $data['participantsCount'] ?? null,
            uniqActions: $data['uniqActions'] ?? null,
            au: isset($data['au']) ? (float)$data['au'] : null,
            postsPerDay: isset($data['postsPerDay']) ? (float)$data['postsPerDay'] : null,
            reactionsPerPost: isset($data['reactionsPerPost']) ? (float)$data['reactionsPerPost'] : null,
            commentsPerPost: isset($data['commentsPerPost']) ? (float)$data['commentsPerPost'] : null,
            engagementRate: isset($data['engagementRate']) ? (float)$data['engagementRate'] : null,
            reactionRate: isset($data['reactionRate']) ? (float)$data['reactionRate'] : null,
            viewRate: isset($data['viewRate']) ? (float)$data['viewRate'] : null,
            commentRate: isset($data['commentRate']) ? (float)$data['commentRate'] : null,
            erView: isset($data['erView']) ? (float)$data['erView'] : null,
            writerToMembers: isset($data['writerToMembers']) ? (float)$data['writerToMembers'] : null,
            writerShare: isset($data['writerShare']) ? (float)$data['writerShare'] : null,
            top10Share: isset($data['top10Share']) ? (float)$data['top10Share'] : null,
            timeBurstIndex: isset($data['timeBurstIndex']) ? (float)$data['timeBurstIndex'] : null,
            growthRate: isset($data['growthRate']) ? (float)$data['growthRate'] : null,
        );
    }

    /**
     * Преобразует даты ISO → string(Carbon)
     */
    private static function mapDateKey(array $data): array
    {
        $result = [];
        foreach ($data as $date => $values) {
            $result[Carbon::parse($date)->toISOString()] = $values;
        }
        return $result;
    }
}
