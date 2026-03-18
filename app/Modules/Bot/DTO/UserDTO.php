<?php

namespace App\Modules\Bot\DTO;

class UserDTO
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
        public ?bool $isBot = null,
        public ?bool $isGeo = null,
        public ?string $lastName = null,
        public ?string $location = null,
        public ?string $locationAddress = null,
        public ?float $locationRadius = null,
        public ?string $number = null,
        public ?int $personalChannelId = null,
        public ?array $pgTags = null,
        public ?string $updatedAt = null,
        public ?string $username = null,
    ) {}

    public static function fromApi(array $data): self
    {
        return new self(
            about: $data['about'] ?? null,
            birthday: $data['birthday'] ?? null,
            botInfo: $data['bot_info'] ?? null,
            firstName: $data['first_name'] ?? null,
            flags: $data['flags'] ?? null,
            flags2: $data['flags2'] ?? null,
            flags2Full: $data['flags2_full'] ?? null,
            flagsFull: $data['flags_full'] ?? null,
            id: isset($data['id']) ? (int)$data['id'] : null,
            idUser: isset($data['id_user']) ? (int)$data['id_user'] : null,
            isBot: isset($data['is_bot']) ? (bool)$data['is_bot'] : null,
            isGeo: isset($data['is_geo']) ? (bool)$data['is_geo'] : null,
            lastName: $data['last_name'] ?? null,
            location: $data['location'] ?? null,
            locationAddress: $data['location_address'] ?? null,
            locationRadius: isset($data['location_radius']) ? (float)$data['location_radius'] : null,
            number: $data['number'] ?? null,
            personalChannelId: isset($data['personal_channel_id']) ? (int)$data['personal_channel_id'] : null,
            pgTags: $data['pg_tags'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            username: $data['username'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'about' => $this->about,
            'birthday' => $this->birthday,
            'bot_info' => $this->botInfo,
            'first_name' => $this->firstName,
            'flags' => $this->flags,
            'flags2' => $this->flags2,
            'flags2_full' => $this->flags2Full,
            'flags_full' => $this->flagsFull,
            'id' => $this->id,
            'id_user' => $this->idUser,
            'is_bot' => $this->isBot,
            'is_geo' => $this->isGeo,
            'last_name' => $this->lastName,
            'location' => $this->location,
            'location_address' => $this->locationAddress,
            'location_radius' => $this->locationRadius,
            'number' => $this->number,
            'personal_channel_id' => $this->personalChannelId,
            'pg_tags' => $this->pgTags,
            'updated_at' => $this->updatedAt,
            'username' => $this->username,
        ];
    }
}
