<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

readonly class DailyRecordData
{
    public function __construct(
        public Carbon $date,
        public int $maleCount,
        public int $femaleCount,
    ) {}
}
