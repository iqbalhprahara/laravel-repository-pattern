<?php

namespace App\Repositories;

use App\Contracts\Repositories\DailyRecordRepository;
use App\DataTransferObjects\DailyRecordData;
use App\Models\DailyRecord;

final class EloquentDailyRecordRepository implements DailyRecordRepository
{
    /**
     * {@inheritdoc}
     */
    public function create(DailyRecordData $dailyRecordData): DailyRecord
    {
        return DailyRecord::create([
            'date' => $dailyRecordData->date,
            'male_count' => $dailyRecordData->maleCount,
            'female_count' => $dailyRecordData->femaleCount,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function update(DailyRecordData $dailyRecordData): DailyRecord
    {
        $dailyRecord = DailyRecord::findOrFail($dailyRecordData->date);

        $dailyRecord->fill([
            'male_count' => $dailyRecordData->maleCount,
            'female_count' => $dailyRecordData->femaleCount,
        ]);

        $dailyRecord->save();

        return $dailyRecord;
    }
}
