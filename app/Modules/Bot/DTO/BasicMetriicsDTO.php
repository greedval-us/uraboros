<?php

namespace App\Modules\Bot\DTO;

use Carbon\Carbon;

class BasicMetriicsDTO
{
    public function __construct(
        public array $activeUsersPerCommAndReactPeriod = [],
        public ?int $activeUsersPerComments = null,
        public ?int $activeUsersPerCommentsAndReactions = null,
        public array $activeUsersPerCommentsPeriod = [],
        public ?int $activeUsersPerGifts = null,
        public array $activeUsersPerGiftsPeriod = [],
        public ?int $activeUsersPerReactions = null,
        public array $activeUsersPerReactionsPeriod = [],

        public ?int $allActiveUsers = null,
        public array $allActiveUsersPeriod = [],

        public ?int $allPublications = null,
        public array $allPublicationsPeriod = [],

        public ?float $commentsPerPost = null,
        public array $commentsPerPostPeriod = [],

        public ?float $engagementRate = null,
        public array $engagementRatePeriod = [],

        public array $stickinessRatioPeriod = [],
        public array $usageRegularityPeriod = [],

        public array $participantChanged = [],

        public ?int $publicationsFromAdmin = null,
        public array $publicationsFromAdminPeriod = [],

        public ?int $publicationsFromUser = null,
        public array $publicationsFromUserPeriod = [],

        public ?float $reactionsPerPost = null,
        public array $reactionsPerPostPeriod = [],
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            activeUsersPerCommAndReactPeriod: self::mapPeriod($data['activeUsersPerCommAndReactPeriod'] ?? []),
            activeUsersPerComments: $data['activeUsersPerComments'] ?? null,
            activeUsersPerCommentsAndReactions: $data['activeUsersPerCommentsAndReactions'] ?? null,
            activeUsersPerCommentsPeriod: self::mapPeriod($data['activeUsersPerCommentsPeriod'] ?? []),

            activeUsersPerGifts: $data['activeUsersPerGifts'] ?? null,
            activeUsersPerGiftsPeriod: self::mapPeriod($data['activeUsersPerGiftsPeriod'] ?? []),

            activeUsersPerReactions: $data['activeUsersPerReactions'] ?? null,
            activeUsersPerReactionsPeriod: self::mapPeriod($data['activeUsersPerReactionsPeriod'] ?? []),

            allActiveUsers: $data['allActiveUsers'] ?? null,
            allActiveUsersPeriod: self::mapPeriod($data['allActiveUsersPeriod'] ?? []),

            stickinessRatioPeriod: self::mapPeriod($data['stickinessRatioPeriod'] ?? []),
            usageRegularityPeriod: self::mapPeriod($data['usageRegularityPeriod'] ?? []),

            allPublications: $data['allPublications'] ?? null,
            allPublicationsPeriod: self::mapPeriod($data['allPublicationsPeriod'] ?? []),

            commentsPerPost: isset($data['commentsPerPost']) ? (float)$data['commentsPerPost'] : null,
            commentsPerPostPeriod: self::mapPeriod($data['commentsPerPostPeriod'] ?? []),

            engagementRate: isset($data['engagementRate']) ? (float)$data['engagementRate'] : null,
            engagementRatePeriod: self::mapPeriod($data['engagementRatePeriod'] ?? []),

            participantChanged: self::mapPeriod($data['participantChanged'] ?? []),

            publicationsFromAdmin: $data['publicationsFromAdmin'] ?? null,
            publicationsFromAdminPeriod: self::mapPeriod($data['publicationsFromAdminPeriod'] ?? []),

            publicationsFromUser: $data['publicationsFromUser'] ?? null,
            publicationsFromUserPeriod: self::mapPeriod($data['publicationsFromUserPeriod'] ?? []),

            reactionsPerPost: isset($data['reactionsPerPost']) ? (float)$data['reactionsPerPost'] : null,
            reactionsPerPostPeriod: self::mapPeriod($data['reactionsPerPostPeriod'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'activeUsersPerCommAndReactPeriod' => $this->activeUsersPerCommAndReactPeriod,
            'activeUsersPerComments' => $this->activeUsersPerComments,
            'activeUsersPerCommentsAndReactions' => $this->activeUsersPerCommentsAndReactions,
            'activeUsersPerCommentsPeriod' => $this->activeUsersPerCommentsPeriod,
            'activeUsersPerGifts' => $this->activeUsersPerGifts,
            'activeUsersPerGiftsPeriod' => $this->activeUsersPerGiftsPeriod,
            'activeUsersPerReactions' => $this->activeUsersPerReactions,
            'activeUsersPerReactionsPeriod' => $this->activeUsersPerReactionsPeriod,
            'allActiveUsers' => $this->allActiveUsers,
            'allActiveUsersPeriod' => $this->allActiveUsersPeriod,
            'allPublications' => $this->allPublications,
            'allPublicationsPeriod' => $this->allPublicationsPeriod,
            'commentsPerPost' => $this->commentsPerPost,
            'commentsPerPostPeriod' => $this->commentsPerPostPeriod,
            'engagementRate' => $this->engagementRate,
            'engagementRatePeriod' => $this->engagementRatePeriod,
            'participantChanged' => $this->participantChanged,
            'publicationsFromAdmin' => $this->publicationsFromAdmin,
            'publicationsFromAdminPeriod' => $this->publicationsFromAdminPeriod,
            'publicationsFromUser' => $this->publicationsFromUser,
            'publicationsFromUserPeriod' => $this->publicationsFromUserPeriod,
            'reactionsPerPost' => $this->reactionsPerPost,
            'reactionsPerPostPeriod' => $this->reactionsPerPostPeriod,
        ];
    }

    private static function mapPeriod(array $data): array
    {
        $result = [];

        foreach ($data as $item) {
            foreach ($item as $date => $value) {
                $result[$date] = $value;
            }
        }

        ksort($result);

        return $result;
    }
}
