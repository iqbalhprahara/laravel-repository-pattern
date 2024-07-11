<?php

namespace App\Repositories;

use App\Contracts\Repositories\HourlyRecordRepository;
use App\DataTransferObjects\HourlyRecordData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class RedisHourlyRecordRepository extends RedisRepository implements HourlyRecordRepository
{
    /**
     * {@inheritdoc}
     */
    protected function redisKey(): string
    {
        return 'hourly_record';
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
