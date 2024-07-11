<?php

use App\Jobs\User\TabulateDailyRecordJob;
use Illuminate\Support\Facades\Schedule;

Schedule::command('user:ingest')
    ->description('Dispatch a job to ingest user data from api')
    ->runInBackground()
    ->hourly();

Schedule::job(
    new TabulateDailyRecordJob(now()->yesterday()->startOfDay()) // tabulate yesterday data
)
    ->monitorName('user:tabulate-daily')
    ->description('Dispatch a job to tabulate hourly record into daily record')
    ->dailyAt('00:01');
