<?php

namespace App\Repositories;

use App\Contracts\Repositories\RandomUserRepository;
use App\Http\Integrations\RandomUser\RandomUser;
use App\Http\Integrations\RandomUser\Requests\GetRandomUser;
use Illuminate\Support\Collection;

final class HttpRandomUserRepository extends HttpRepository implements RandomUserRepository
{
    /**
     * {@inheritdoc}
     */
    protected function getConnectorClass(): string
    {
        return RandomUser::class;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $userCount = 20): Collection
    {
        return $this->connector()->send(new GetRandomUser($userCount))->collect('results');
    }
}
