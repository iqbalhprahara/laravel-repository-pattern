<?php

namespace App\Repositories;

use App\Contracts\Repositories\HourlyRecordRepository;
use App\DataTransferObjects\HourlyRecordData;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class RedisHourlyRecordRepository implements HourlyRecordRepository
{
    /**
     * @var \Illuminate\Redis\Connections\Connection
     */
    protected $connection;

    public const REDIS_KEY = 'hourly_data';

    public function __construct(Redis $redis, string $connection = 'default')
    {
        $this->connection = $redis->connection($connection);
    }

    /**
     * Execute a command on redis connection to the key store
     */
    protected function executeCommand($command, array $parameters)
    {
        return $this->connection->command($command, array_merge(
            [self::REDIS_KEY],
            $parameters,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function create(HourlyRecordData $hourlyRecordData): bool
    {
        return (bool) $this->executeCommand('zadd', [
            $hourlyRecordData->timestamp->timestamp,
            $hourlyRecordData->serialize(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByDate(Carbon $date): Collection
    {
        $startOfDay = $date->clone()->startOfDay()->timestamp;
        $endOfDay = $date->clone()->endOfDay()->timestamp;

        $results = $this->executeCommand('zrangebyscore', [$startOfDay, $endOfDay]);

        return collect($results)->map(fn ($result) => HourlyRecordData::fromSerializedData($result));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAllByDate(Carbon $date): bool
    {
        $startOfDay = $date->clone()->startOfDay()->timestamp;
        $endOfDay = $date->clone()->endOfDay()->timestamp;

        return (bool) $this->executeCommand('zremrangebyscore', [$startOfDay, $endOfDay]);
    }
}
