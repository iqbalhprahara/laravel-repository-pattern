<?php

namespace App\Http\Integrations\RandomUser;

use Saloon\Contracts\Sender;
use Saloon\Http\Connector;
use Saloon\Http\Senders\GuzzleSender;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class RandomUser extends Connector
{
    use AcceptsJson, AlwaysThrowOnErrors;

    public ?int $tries = 5;

    public ?int $retryInterval = 500;

    public ?bool $useExponentialBackoff = true;

    protected function defaultSender(): Sender
    {
        return resolve(GuzzleSender::class);
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return config('services.random_user.url');
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
