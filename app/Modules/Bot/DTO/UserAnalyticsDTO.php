<?php

namespace App\Modules\Bot\DTO;

class UserAnalyticsDTO
{
    public function __construct(
        public ?array $activityByGroups = null,
        public ?array $activityPeriod = null,
        public ?array $allActivity = null,
        public ?array $groups = null,
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            activityByGroups: self::mapActivityByGroups($data['activityByGroups'] ?? []),
            activityPeriod: self::mapActivityPeriod($data['activityPeriod'] ?? []),
            allActivity: self::mapStats($data['allActivity'] ?? null),
            groups: self::mapGroups($data['groups'] ?? []),
        );
    }

    private static function mapActivityByGroups(array $items): array
    {
        return array_map(function ($item) {
            $groupId = array_key_first($item);
            $stats = $item[$groupId] ?? [];

            return [
                'groupId' => (int)$groupId,
                'allGifts' => (int)($stats['allGifts'] ?? 0),
                'allMessages' => (int)($stats['allMessages'] ?? 0),
                'allReactions' => (int)($stats['allReactions'] ?? 0),
            ];
        }, $items);
    }

    private static function mapActivityPeriod(array $items): array
    {
        return array_map(function ($item) {
            $date = array_key_first($item);
            $stats = $item[$date];

            return [
                'date' => $date,
                'allGifts' => (int)($stats['allGifts'] ?? 0),
                'allMessages' => (int)($stats['allMessages'] ?? 0),
                'allReactions' => (int)($stats['allReactions'] ?? 0),
                'isEmpty' => $stats === null,
            ];
        }, $items);
    }

    private static function mapStats(?array $data): ?array
    {
        if (!$data) {
            return null;
        }

        return [
            'allGifts' => (int)($data['allGifts'] ?? 0),
            'allMessages' => (int)($data['allMessages'] ?? 0),
            'allReactions' => (int)($data['allReactions'] ?? 0),
        ];
    }

    private static function mapGroups(array $items): array
    {
        return array_map(function ($group) {
            return [
                'createdDate' => $group['createdDate'] ?? null,
                'findGroup' => $group['findGroup'] ?? null,

                'flags' => self::normalizeArray($group['flags'] ?? null),
                'flags2' => self::normalizeArray($group['flags2'] ?? null),

                'hashGroup' => $group['hashGroup'] ?? null,

                'id' => isset($group['id']) ? (int)$group['id'] : null,
                'idGroup' => isset($group['idGroup']) ? (int)$group['idGroup'] : null,

                'infoGroup' => $group['infoGroup'] ?? null,
                'isHandle' => isset($group['isHandle']) ? (bool)$group['isHandle'] : null,

                'joinedDate' => $group['joinedDate'] ?? null,
                'lastUpdate' => $group['lastUpdate'] ?? null,

                'linkedId' => isset($group['linkedId']) ? (int)$group['linkedId'] : null,
                'participantsCount' => isset($group['participantsCount']) ? (int)$group['participantsCount'] : null,

                'titleGroup' => $group['titleGroup'] ?? null,
                'type' => isset($group['type']) ? (int)$group['type'] : null,
            ];
        }, $items);
    }

    private static function normalizeArray(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value)) {
            return array_map('trim', explode(',', $value));
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'activityByGroups' => $this->activityByGroups,
            'activityPeriod' => $this->activityPeriod,
            'allActivity' => $this->allActivity,
            'groups' => $this->groups,
        ];
    }
}
