<?php

namespace App\Observers\User;

use App\Contracts\Repositories\DailyRecordRepository;
use App\Contracts\Repositories\HourlyRecordRepository;
use App\DataTransferObjects\HourlyRecordData;
use App\Models\User;

class UserDeletedObserver
{
    public function __construct(
        protected DailyRecordRepository $dailyRecordRepository,
        protected HourlyRecordRepository $hourlyRecordRepository,
    ) {}

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if ($this->dailyRecordRepository->existsByDate($user->created_at)) {
            $this->handleDecrementOnDailyRecordRepository($user);
        } else {
            $this->handleDecrementOnHourlyRecordRepository($user);
        }
    }

    /**
     * Decrement user count on daily record repository
     */
    protected function handleDecrementOnDailyRecordRepository(User $user)
    {
        $method = 'decrement'.ucfirst($user->gender).'CountByDate';

        return $this->dailyRecordRepository->$method($user->created_at, 1);
    }

    /**
     * Insert decrement record to hourly record repository
     */
    protected function handleDecrementOnHourlyRecordRepository(User $user)
    {
        return $this->hourlyRecordRepository->create(
            new HourlyRecordData(
                timestamp: $user->created_at,
                maleCount: $user->gender === 'male' ? -1 : 0,
                femaleCount: $user->gender === 'female' ? -1 : 0,
            )
        );
    }
}
