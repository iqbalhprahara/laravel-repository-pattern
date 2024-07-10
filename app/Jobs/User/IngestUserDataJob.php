<?php

namespace App\Jobs\User;

use App\Actions\User\IngestUserData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class IngestUserDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Carbon $timestamp
    ) {}

    /**
     * Execute the job.
     */
    public function handle(IngestUserData $action): void
    {
        $action->execute($this->timestamp);
    }
}
