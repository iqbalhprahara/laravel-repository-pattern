<?php

namespace App\Repositories;

use App\Contracts\Repositories\RandomUserRepository;
use App\Http\Integrations\RandomUser\RandomUser;
use App\Http\Integrations\RandomUser\Requests\GetRandomUser;
use Illuminate\Support\Collection;

final class ApiRandomUserRepository implements RandomUserRepository
{
    public function __construct(
        protected RandomUser $connector,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function get(int $userCount = 20): Collection
    {
        return $this->connector->send(new GetRandomUser($userCount))->collect('results');
    }
}
