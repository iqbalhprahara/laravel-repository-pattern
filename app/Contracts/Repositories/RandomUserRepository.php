<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface RandomUserRepository
{
    /**
     * Get (n) number of random user
     *
     * @param int $userCount number of random user to get
     *
     * @return Collection
     */
    public function get(int $userCount = 20): Collection;
}
