<?php

namespace App\Http\Integrations\RandomUser\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRandomUser extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(
        public readonly int $userCount
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/';
    }

    protected function defaultQuery(): array
    {
        return [
            'results' => $this->userCount,
        ];
    }
}
