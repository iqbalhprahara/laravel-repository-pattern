<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Actions\User\IngestUserData;
use App\Actions\User\TabulateDailyRecord;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(IngestUserData $ingestUserAction, TabulateDailyRecord $tabulateAction): void
    {
        $startTime = Carbon::now()->subDays(7)->startOfDay();
        $endTime = $startTime->clone()->addDays(6)->endOfDay();
        $dayIntervals = CarbonInterval::day()->toPeriod($startTime, $endTime);

        /** @var Carbon $dayInterval */
        foreach ($dayIntervals as $dayInterval) {
            $this->command->info("Generating data for {$dayInterval->toDateString()}");
            $ingestUserAction->execute($dayInterval);
            $tabulateAction->execute($dayInterval);
        }
    }
}
