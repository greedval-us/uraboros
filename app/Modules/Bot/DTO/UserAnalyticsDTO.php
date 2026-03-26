<?php

namespace App\Modules\Bot\DTO;

class UserAnalyticsDTO
{
    /** @var array<int, array> groupId => stats */
    public array $activityByGroups;

    /** @var array<string, array> date => stats */
    public array $activityPeriod;

    /** @var array<string, int>|null */
    public ?array $allActivity;

    /** @var array<int, array> normalized groups */
    public array $groups;

    public function __construct(
        array $activityByGroups = [],
        array $activityPeriod = [],
        ?array $allActivity = null,
        array $groups = []
    ) {
        $this->activityByGroups = $activityByGroups;
        $this->activityPeriod = $activityPeriod;
        $this->allActivity = $allActivity;
        $this->groups = $groups;
    }

    /**
     * Создание DTO из API
     */
    public static function fromApi(array $data): self
    {
        return new self(
            activityByGroups: self::mapActivityByGroups($data['activityByGroups'] ?? []),
            activityPeriod: self::mapActivityPeriod($data['activityPeriod'] ?? []),
            allActivity: self::mapStats($data['allActivity'] ?? null),
            groups: self::mapGroups($data['groups'] ?? [])
        );
    }

    /**
     * Приведение activityByGroups к keyed массиву
     */
    private static function mapActivityByGroups(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $groupId = (int)array_key_first($item);
            $stats = $item[$groupId] ?? [];
            $result[$groupId] = self::mapStats($stats);
        }
        return $result;
    }

    /**
     * Приведение activityPeriod к keyed массиву по дате
     */
    private static function mapActivityPeriod(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            foreach ($item as $date => $stats) {
                $result[$date] = [
                    'allGifts' => (int)($stats['allGifts'] ?? 0),
                    'allMessages' => (int)($stats['allMessages'] ?? 0),
                    'allReactions' => (int)($stats['allReactions'] ?? 0),
                    'isEmpty' => $stats === null,
                ];
            }
        }

        ksort($result);
        return $result;
    }

    /**
     * Нормализация статистики
     */
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

    /**
     * Нормализация групп
     */
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

    /**
     * Нормализация CSV/строк в массив
     */
    private static function normalizeArray(mixed $value): ?array
    {
        if ($value === null) return null;

        if (is_string($value)) {
            $value = explode(',', $value);
        }

        if (!is_array($value)) return null;

        $value = array_map(fn($v) => trim((string)$v), $value);
        $value = array_filter($value, fn($v) => $v !== '');
        return array_values($value) ?: null;
    }

    /**
     * Преобразование DTO в массив
     */
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
