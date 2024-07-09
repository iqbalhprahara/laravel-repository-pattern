<?php

namespace App\DataTransferObjects;

class UserData
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $gender,
        public readonly array $name,
        public readonly array $location,
        public readonly int $age,
    ) {}

    public static function fromRandomUserData(array $data)
    {
        return new static(
            uuid: $data['login']['uuid'],
            gender: $data['gender'],
            name: $data['name'],
            location: $data['location'],
            age: $data['dob']['age'],
        );
    }
}
