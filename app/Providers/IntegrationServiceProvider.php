<?php

namespace App\Providers;

use App\Http\Integrations\RandomUser\RandomUser;
use Illuminate\Support\ServiceProvider;
use Saloon\Http\Senders\GuzzleSender;

class IntegrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GuzzleSender::class);
        $this->app->singleton(RandomUser::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
