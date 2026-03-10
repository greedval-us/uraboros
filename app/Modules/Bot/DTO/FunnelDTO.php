<?php

namespace App\Modules\Bot\DTO;

class FunnelDTO
{
    public function __construct(
        public array $ERperDay = [],
        public array $ERviewPeriod = [],
        public ?float $allCommentRate = null,
        public ?float $allERview = null,
        public ?float $allReactionRate = null,
        public ?float $allViewRate = null,
        public array $commentRatePeriod = [],
        public array $reactionRatePeriod = [],
        public array $viewRatePeriod = [],
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            ERperDay: self::mapERPerDay($data['ERperDay'] ?? []),

            ERviewPeriod: self::mapPeriod($data['ERviewPeriod'] ?? []),

            allCommentRate: isset($data['allCommentRate']) ? (float)$data['allCommentRate'] : null,
            allERview: isset($data['allERview']) ? (float)$data['allERview'] : null,
            allReactionRate: isset($data['allReactionRate']) ? (float)$data['allReactionRate'] : null,
            allViewRate: isset($data['allViewRate']) ? (float)$data['allViewRate'] : null,

            commentRatePeriod: self::mapPeriod($data['commentRatePeriod'] ?? []),
            reactionRatePeriod: self::mapPeriod($data['reactionRatePeriod'] ?? []),
            viewRatePeriod: self::mapPeriod($data['viewRatePeriod'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'ERperDay' => $this->ERperDay,
            'ERviewPeriod' => $this->ERviewPeriod,
            'allCommentRate' => $this->allCommentRate,
            'allERview' => $this->allERview,
            'allReactionRate' => $this->allReactionRate,
            'allViewRate' => $this->allViewRate,
            'commentRatePeriod' => $this->commentRatePeriod,
            'reactionRatePeriod' => $this->reactionRatePeriod,
            'viewRatePeriod' => $this->viewRatePeriod,
        ];
    }

    private static function mapERPerDay(array $data): array
    {
        $result = [];

        foreach ($data as $item) {
            foreach ($item as $date => $metrics) {
                $result[$date] = [
                    'ERview' => $metrics['ERview'] ?? null,
                    'commentRate' => $metrics['commentRate'] ?? null,
                    'reactionRate' => $metrics['reactionRate'] ?? null,
                    'viewRate' => $metrics['viewRate'] ?? null,
                ];
            }
        }

        ksort($result);

        return $result;
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
