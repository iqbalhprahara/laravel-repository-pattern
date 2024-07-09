<?php

namespace App\Console\Commands\User;

use App\Jobs\User\GenerateUser;
use Illuminate\Console\Command;

class DispatchGenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatching a job to generate user data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GenerateUser::dispatch();

        $this->info('A job to generate users has been dispatched');
    }
}
