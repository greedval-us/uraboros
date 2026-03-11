<?php

namespace App\Modules\Bot\DTO;

class UserLeadersDTO
{
    public function __construct(
        public array $top10ByMessage = [],
        public array $top10ByMessageAndReaction = [],
        public array $top10ByReaction = [],
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            top10ByMessage: self::mapTop10($data['top10ByMessage'] ?? []),
            top10ByMessageAndReaction: self::mapTop10($data['top10ByMessageAndReaction'] ?? []),
            top10ByReaction: self::mapTop10($data['top10ByReaction'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'top10ByMessage' => $this->top10ByMessage,
            'top10ByMessageAndReaction' => $this->top10ByMessageAndReaction,
            'top10ByReaction' => $this->top10ByReaction,
        ];
    }

    private static function mapTop10(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            foreach ($item as $id => $count) {
                $result[$id] = $count;
            }
        }

        arsort($result); // сортируем по убыванию, чтобы топ был сверху
        return $result;
    }
}
