<?php

namespace App\Contracts\Repositories;

use App\DataTransferObjects\UserData;
use Illuminate\Support\Carbon;

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
     * Delete user on repository by uuid
     *
     * @param  string  $uuid  the uuid of the user
     */
    public function delete(string $uuid): bool;

    /**
     * Get user by uuid
     *
     * @param  string  $uuid  the uuid of te user
     */
    public function getByUuid(string $uuid);

    /**
     * Check if uuid already exists on repository
     *
     * @var string $uuid
     */
    public function existsByUuid(string $uuid): bool;

    /**
     * Get average age of user created on certain date
     *
     * @var Carbon $date date of the user created
     * @var null|string $gender gender of the user
     */
    public function getAverageAgeByDate(Carbon $date, ?string $gender = null): int;
}
