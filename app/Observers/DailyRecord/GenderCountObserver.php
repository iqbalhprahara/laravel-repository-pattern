<?php

namespace App\Observers\DailyRecord;

use App\Contracts\Repositories\UserRepository;
use App\Models\DailyRecord;
use Illuminate\Support\Carbon;

class GenderCountObserver
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    /**
     * Handle the DailyRecord "saving" event.
     */
    public function saving(DailyRecord $dailyRecord): void
    {
        $this->detectGenderCountChange($dailyRecord);
    }

    /**
     * Detect if male_count or female_count attributes has been changed
     */
    protected function detectGenderCountChange(DailyRecord $dailyRecord)
    {
        if ($dailyRecord->isDirty('male_count')) {
            $dailyRecord->male_avg_age = $this->userRepository->getAverageAgeByDate(
                Carbon::createFromImmutable($dailyRecord->date),
                'male'
            );
        }

        if ($dailyRecord->isDirty('female_count')) {
            $dailyRecord->female_avg_age = $this->userRepository->getAverageAgeByDate(
                Carbon::createFromImmutable($dailyRecord->date),
                'female'
            );
        }
    }
}
