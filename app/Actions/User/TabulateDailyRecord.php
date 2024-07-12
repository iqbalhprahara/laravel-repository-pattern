<?php

namespace App\Actions\User;

use App\Contracts\Repositories\DailyRecordRepository;
use App\Contracts\Repositories\HourlyRecordRepository;
use App\DataTransferObjects\DailyRecordData;
use Illuminate\Support\Carbon;

class TabulateDailyRecord
{
    /**
     * The default value of how much user data to be ingested
     *
     * @var int
     */
    protected const DEFAULT_INGEST_COUNT = 20;

    public function __construct(
        protected HourlyRecordRepository $hourlyRecordRepository,
        protected DailyRecordRepository $dailyRecordRepository,
    ) {}

    public function execute(Carbon $date, bool $deleteHourlyData = true)
    {
        $hourlyRecords = $this->hourlyRecordRepository->findAllByDate($date);

        $dailyRecords = new DailyRecordData(
            date: $date,
            maleCount: $hourlyRecords->sum('maleCount'),
            femaleCount: $hourlyRecords->sum('femaleCount'),
        );

        $this->dailyRecordRepository->create($dailyRecords);

        if ($deleteHourlyData) {
            $this->hourlyRecordRepository->deleteAllByDate($date);
        }
    }
}
