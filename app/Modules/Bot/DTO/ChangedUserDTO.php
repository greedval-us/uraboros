<?php

namespace App\Modules\Bot\DTO;

class ChangedUserDTO
{
    public function __construct(
        public ?string $about = null,
        public ?string $birthday = null,
        public ?string $botInfo = null,
        public ?string $firstName = null,

        public ?array $flags = null,
        public ?array $flags2 = null,
        public ?array $flags2Full = null,
        public ?array $flagsFull = null,

        public ?int $id = null,
        public ?int $idUser = null,

        public ?string $lastName = null,

        public ?string $locationAddress = null,
        public ?float $locationLat = null,
        public ?float $locationLon = null,
        public ?float $locationRadius = null,

        public ?string $number = null,
        public ?int $personalChannelId = null,

        public ?string $updatedAt = null,
        public ?string $userPhoto = null,
        public ?string $username = null,
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            about: $data['about'] ?? null,
            birthday: $data['birthday'] ?? null,
            botInfo: $data['botInfo'] ?? null,
            firstName: $data['firstName'] ?? null,

            flags: self::normalizeArray($data['flags'] ?? null),
            flags2: self::normalizeArray($data['flags2'] ?? null),
            flags2Full: self::normalizeArray($data['flags2Full'] ?? null),
            flagsFull: self::normalizeArray($data['flagsFull'] ?? null),

            id: isset($data['id']) ? (int)$data['id'] : null,
            idUser: isset($data['idUser']) ? (int)$data['idUser'] : null,

            lastName: $data['lastName'] ?? null,

            locationAddress: $data['locationAddress'] ?? null,
            locationLat: isset($data['locationLat']) ? (float)$data['locationLat'] : null,
            locationLon: isset($data['locationLon']) ? (float)$data['locationLon'] : null,
            locationRadius: isset($data['locationRadius']) ? (float)$data['locationRadius'] : null,

            number: $data['number'] ?? null,
            personalChannelId: isset($data['personalChannelId']) ? (int)$data['personalChannelId'] : null,

            updatedAt: $data['updatedAt'] ?? null,
            userPhoto: $data['userPhoto'] ?? null,
            username: $data['username'] ?? null,
        );
    }

    public static function fromApiList(array $items): array
    {
        return array_map(
            fn ($item) => self::fromApi($item),
            $items
        );
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
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return [$value];
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'about' => $this->about,
            'birthday' => $this->birthday,
            'botInfo' => $this->botInfo,
            'firstName' => $this->firstName,

            'flags' => $this->flags,
            'flags2' => $this->flags2,
            'flags2Full' => $this->flags2Full,
            'flagsFull' => $this->flagsFull,

            'id' => $this->id,
            'idUser' => $this->idUser,

            'lastName' => $this->lastName,

            'locationAddress' => $this->locationAddress,
            'locationLat' => $this->locationLat,
            'locationLon' => $this->locationLon,
            'locationRadius' => $this->locationRadius,

            'number' => $this->number,
            'personalChannelId' => $this->personalChannelId,

            'updatedAt' => $this->updatedAt,
            'userPhoto' => $this->userPhoto,
            'username' => $this->username,
        ];
    }
}
