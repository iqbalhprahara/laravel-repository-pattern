<?php

namespace App\Repositories;

use App\Contracts\Repositories\DailyRecordRepository;
use App\DataTransferObjects\DailyRecordData;
use App\Models\DailyRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class EloquentDailyRecordRepository extends EloquentRepository implements DailyRecordRepository
{
    /**
     * {@inheritdoc}
     */
    protected function model(): Model
    {
        return new DailyRecord;
    }

    /**
     * {@inheritdoc}
     */
    public function create(DailyRecordData $dailyRecordData): DailyRecord
    {
        return $this->model()
            ->create([
                'date' => $dailyRecordData->date,
                'male_count' => $dailyRecordData->maleCount,
                'female_count' => $dailyRecordData->femaleCount,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getByDate(Carbon $date, bool $lockForUpdate = false): DailyRecord
    {
        return $this->model()
            ->where('date', $date)
            ->when($lockForUpdate, fn ($query) => $query->lockForUpdate())
            ->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function existsByDate(Carbon $date): bool
    {
        return $this->model()->where('date', $date)->exists();
    }

    /**
     * {@inheritdoc}
     */
    public function decrementMaleCountByDate(Carbon $date, int $amount)
    {
        $dailyRecord = $this->getByDate($date, true);
        $dailyRecord->male_count = $dailyRecord->male_count - $amount;
        $dailyRecord->save();
    }

    /**
     * {@inheritdoc}
     */
    public function decrementFemaleCountByDate(Carbon $date, int $amount)
    {
        $dailyRecord = $this->getByDate($date, true);
        $dailyRecord->female_count = $dailyRecord->female_count - $amount;
        $dailyRecord->save();
    }
}
