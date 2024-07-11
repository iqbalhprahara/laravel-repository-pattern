<?php

namespace App\Observers\DailyRecord;

use App\Contracts\Repositories\UserRepository;
use App\Models\DailyRecord;
use Illuminate\Support\Carbon;

class FemaleCountObserver
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    /**
     * Handle the DailyRecord "saving" event.
     */
    public function saving(DailyRecord $dailyRecord): void
    {
        if ($dailyRecord->isDirty('female_count')) {
            $dailyRecord->female_avg_age = $this->userRepository->getAverageAgeByDate(Carbon::createFromImmutable($dailyRecord->date), 'female');
        }
    }
}
