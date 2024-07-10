<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\DataTransferObjects\UserData;
use App\Models\User;

final class EloquentUserRepository implements UserRepository
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function uuidExists(string $uuid): bool
    {
        return User::where('uuid', $uuid)->exists();
    }
}
