<?php

namespace App\Contracts\Repositories;

use App\DataTransferObjects\DailyRecordData;
use Illuminate\Support\Carbon;

interface DailyRecordRepository
{
    /**
     * Create new  daily record data on repository
     *
     * @param  DailyRecordData  $dailyRecordData  data transfer object for daily record
     */
    public function create(DailyRecordData $dailyRecordData);

    /**
     * Get a record by date
     */
    public function getByDate(Carbon $date);

    /**
     * Check if a record exists by date
     */
    public function existsByDate(Carbon $date): bool;

    /**
     * Decrease male count of a record specified by date
     *
     * @param  Carbon  $date  date of the record
     * @param  int  $amount  amount to decrease
     */
    public function decrementMaleCountByDate(Carbon $date, int $amount);

    /**
     * Decrease female count of a record specified by date
     *
     * @param  Carbon  $date  date of the record
     * @param  int  $amount  amount to decrease
     */
    public function decrementFemaleCountByDate(Carbon $date, int $amount);
}
