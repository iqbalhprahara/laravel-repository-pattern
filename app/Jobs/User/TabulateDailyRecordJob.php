<?php

namespace App\Jobs\User;

use App\Actions\User\TabulateDailyRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class TabulateDailyRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Carbon $date
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TabulateDailyRecord $action): void
    {
        $action->execute($this->date);
    }
}
