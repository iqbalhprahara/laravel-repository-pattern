<?php

namespace App\Contracts\Repositories;

use App\DataTransferObjects\HourlyRecordData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface HourlyRecordRepository
{
    /**
     * Create new  hourly record data on repository
     *
     * @param  HourlyRecordData  $hourlyRecordData  data transfer object for hourly record data
     */
    public function create(HourlyRecordData $hourlyRecordData);

    /**
     * Find all hourly records by date specified in argument
     *
     * @param  Carbon  $date  date of the records
     * @return Collection<HourlyRecordData>
     */
    public function findAllByDate(Carbon $date): Collection;

    /**
     * Delete all hourly records by date specified in argument
     *
     * @param  Carbon  $date  date of the records
     */
    public function deleteAllByDate(Carbon $date): bool;
}
