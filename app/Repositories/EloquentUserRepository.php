<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\DataTransferObjects\UserData;
use App\Models\User;

final class EloquentUserRepository implements UserRepository
{
    public function create(UserData $userData): User
    {
        return User::create([
            'uuid' => $userData->uuid,
            'gender' => $userData->gender,
            'name' => $userData->name,
            'location' => $userData->location,
            'age' => $userData->age,
        ]);
    }

    public function update(UserData $userData): User
    {
        $user = User::findOrFail($userData->uuid);

        $user->fill([
            'gender' => $userData->gender,
            'name' => $userData->name,
            'location' => $userData->location,
            'age' => $userData->age,
        ]);

        $user->save();

        return $user;
    }

    public function uuidExists(string $uuid): bool
    {
        return User::where('uuid', $uuid)->exists();
    }
}
