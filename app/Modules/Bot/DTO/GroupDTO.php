<?php

namespace App\Midules\Bot\DTO;

use Carbon\Carbon;

class GroupDTO
{
    public function __construct(
        public ?int $id,
        public ?int $idGroup,
        public ?string $infoGroup,
        public ?string $titleGroup,
        public ?string $findGroup,
        public ?string $hashGroup,
        public ?int $type,
        public ?int $handlersId,
        public ?Carbon $lastUpdate,
        public ?int $linkedId,
        public ?int $participantsCount,
        public ?Carbon $createdDate,
        public ?string $flags,
        public ?string $flags2,
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            idGroup: $data['idGroup'] ?? null,
            infoGroup: $data['infoGroup'] ?? null,
            titleGroup: $data['titleGroup'] ?? null,
            findGroup: $data['findGroup'] ?? null,
            hashGroup: $data['hashGroup'] ?? null,
            type: $data['type'] ?? null,
            handlersId: $data['handlersId'] ?? null,
            lastUpdate: isset($data['lastUpdate']) ? Carbon::parse($data['lastUpdate']) : null,
            linkedId: $data['linkedId'] ?? null,
            participantsCount: $data['participantsCount'] ?? null,
            createdDate: isset($data['createdDate']) ? Carbon::parse($data['createdDate']) : null,
            flags: $data['flags'] ?? null,
            flags2: $data['flags2'] ?? null,
        );
    }
}
