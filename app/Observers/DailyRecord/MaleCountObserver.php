<?php

namespace App\Observers\DailyRecord;

use App\Contracts\Repositories\UserRepository;
use App\Models\DailyRecord;
use Illuminate\Support\Carbon;

class MaleCountObserver
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    /**
     * Handle the DailyRecord "saving" event.
     */
    public function saving(DailyRecord $dailyRecord): void
    {
        if ($dailyRecord->isDirty('male_count')) {
            $dailyRecord->male_avg_age = $this->userRepository->getAverageAgeByDate(Carbon::createFromImmutable($dailyRecord->date), 'male');
        }
    }
}
