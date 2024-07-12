<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class HourlyRecordData
{
    public function __construct(
        public Carbon $timestamp,
        public int $maleCount,
        public int $femaleCount,
    ) {}

    /**
     * Generate uuid for the instance
     */
    protected static function generateUuid(): string
    {
        return (string) \Illuminate\Support\Str::orderedUuid();
    }

    public function serialize()
    {
        return serialize([
            'uuid' => static::generateUuid(),
            'timestamp' => $this->timestamp->timestamp,
            'male_count' => $this->maleCount,
            'female_count' => $this->femaleCount,
        ]);
    }

    public static function fromSerializedData(string $serializedData)
    {
        $data = unserialize($serializedData);

        $timestamp = Carbon::createFromTimestamp($data['timestamp'], config('app.timezone'));

        return new static(
            $timestamp,
            $data['male_count'],
            $data['female_count'],
        );
    }
}
