<?php

namespace App\Contracts\Repositories;

use App\DataTransferObjects\DailyRecordData;

interface DailyRecordRepository
{
    /**
     * Create new  daily record data on repository
     *
     * @param  DailyRecordData  $dailyRecordData  data transfer object for daily record
     */
    public function create(DailyRecordData $dailyRecordData);

    /**
     * Update current daily record data on repository
     *
     * @param  DailyRecordData  $dailyRecordData  data transfer object for daily record
     */
    public function update(DailyRecordData $dailyRecordData);
}
