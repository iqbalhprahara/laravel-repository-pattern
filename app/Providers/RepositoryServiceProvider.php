<?php

namespace App\Providers;

use App\Contracts;
use App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Contracts\Repositories\RandomUserRepository::class, Repositories\ApiRandomUserRepository::class);
        $this->app->singleton(Contracts\Repositories\UserRepository::class, Repositories\EloquentUserRepository::class);
        $this->app->singleton(Contracts\Repositories\HourlyRecordRepository::class, Repositories\RedisHourlyRecordRepository::class);
        $this->app->singleton(Contracts\Repositories\DailyRecordRepository::class, Repositories\EloquentDailyRecordRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
