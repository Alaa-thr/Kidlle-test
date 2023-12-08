<?php

namespace App\Providers;

use App\Interfaces\IPaiment;
use Illuminate\Support\ServiceProvider;
use App\Services\PaimentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPaiment::class, function () {
            return new PaimentService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
