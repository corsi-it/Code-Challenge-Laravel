<?php

namespace App\Providers;

use App\Services\ProcessProductFileService;
use App\Services\ProcessProductFileServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProcessProductFileServiceInterface::class, ProcessProductFileService::class);
    }
}
