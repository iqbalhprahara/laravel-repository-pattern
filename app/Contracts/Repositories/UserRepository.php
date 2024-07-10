<?php

namespace App\Contracts\Repositories;

use App\DataTransferObjects\UserData;

interface UserRepository
{
    /**
     * Create new  user data on repository
     *
     * @param  UserData  $userData  data transfer object for user data
     */
    public function create(UserData $userData);

    /**
     * Update current user data on repository
     *
     * @param  UserData  $userData  data transfer object for user data
     */
    public function update(UserData $userData);

    /**
     * Check if uuid already exists on repository
     *
     * @var string $uuid
     */
    public function uuidExists(string $uuid): bool;
}
