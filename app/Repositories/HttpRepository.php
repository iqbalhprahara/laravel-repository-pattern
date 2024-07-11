<?php

namespace App\Repositories;

use Saloon\Http\Connector;

abstract class HttpRepository
{
    /**
     * Get the http connector class name
     */
    abstract protected function getConnectorClass(): string;

    /**
     * Resolve connector from container
     */
    protected function connector(): Connector
    {
        return resolve($this->getConnectorClass());
    }
}
