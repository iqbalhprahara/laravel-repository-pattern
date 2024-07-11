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
     * Check if uuid already exists on repository
     *
     * @var string $uuid
     */
    public function uuidExists(string $uuid): bool;

    /**
     * Get average age of user created on certain date
     *
     * @var Carbon $date date of the user created
     * @var null|string $gender gender of the user
     */
    public function getAverageAgeByDate(Carbon $date, ?string $gender = null): int;
}
