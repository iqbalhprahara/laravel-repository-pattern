<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

class HourlyRecordData
{
    public function __construct(
        public readonly Carbon $timestamp,
        public readonly int $maleCount,
        public readonly int $femaleCount,
    ) {}

    public function serialize()
    {
        return serialize([
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
