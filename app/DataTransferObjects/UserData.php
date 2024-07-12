<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class UserData
{
    public function __construct(
        public string $uuid,
        public string $gender,
        public array $name,
        public array $location,
        public int $age,
        public ?Carbon $createdAt = null,
    ) {}

    public static function fromRandomUserData(array $data, ?Carbon $createdAt = null)
    {
        return new static(
            uuid: $data['login']['uuid'],
            gender: $data['gender'],
            name: $data['name'],
            location: $data['location'],
            age: $data['dob']['age'],
            createdAt: $createdAt,
        );
    }
}
