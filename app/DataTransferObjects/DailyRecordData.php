<?php

namespace App\DataTransferObjects;

use Illuminate\Support\Carbon;

class DailyRecordData
{
    public function __construct(
        public readonly Carbon $date,
        public readonly int $maleCount,
        public readonly int $femaleCount,
    ) {}
}
