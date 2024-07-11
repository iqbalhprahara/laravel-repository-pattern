<?php

namespace App\Repositories;

use Illuminate\Contracts\Redis\Factory as Redis;

abstract class RedisRepository
{
    /**
     * @var \Illuminate\Redis\Connections\Connection
     */
    protected $connection;

    public function __construct(Redis $redis, string $connection = 'default')
    {
        $this->connection = $redis->connection($connection);
    }

    /**
     * Get redis key of repository data
     */
    abstract protected function redisKey(): string;

    /**
     * Execute a command on redis connection to the key store
     */
    protected function executeCommand($command, array $parameters)
    {
        return $this->connection->command($command, array_merge(
            [$this->redisKey()],
            $parameters,
        ));
    }
}
