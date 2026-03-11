<?php

namespace App\Modules\Bot\DTO;

class AudienceQualityDTO
{
    public function __construct(
        public array $timeBurstIndexPerDay = [],
        public ?float $writerToMembersAll = null,
        public array $writerToMembersPeriod = [],
        public ?float $writerToShareAll = null,
        public array $writerToSharePeriod = [],
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            timeBurstIndexPerDay: self::mapPeriod($data['timeBurstIndexPeriod'] ?? []),
            writerToMembersAll: isset($data['writerToMembersAll']) ? (float)$data['writerToMembersAll'] : null,
            writerToMembersPeriod: self::mapPeriod($data['writerToMembersPeriod'] ?? []),
            writerToShareAll: isset($data['writerToShareAll']) ? (float)$data['writerToShareAll'] : null,
            writerToSharePeriod: self::mapPeriod($data['writerToSharePeriod'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'timeBurstIndexPerDay' => $this->timeBurstIndexPerDay,
            'writerToMembersAll' => $this->writerToMembersAll,
            'writerToMembersPeriod' => $this->writerToMembersPeriod,
            'writerToShareAll' => $this->writerToShareAll,
            'writerToSharePeriod' => $this->writerToSharePeriod,
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
