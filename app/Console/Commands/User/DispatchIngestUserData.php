<?php

namespace App\Console\Commands\User;

use App\Jobs\User\IngestUserDataJob;
use Illuminate\Console\Command;

class DispatchIngestUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:ingest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatching a job to ingest user data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = now();
        IngestUserDataJob::dispatch($currentTime);

        $this->info('A job to ingest user data has been dispatched');
    }
}
