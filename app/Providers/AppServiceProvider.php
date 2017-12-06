<?php

namespace App\Providers;

use App\Source\Definition;
use App\Source\Synonym;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Synonym', Synonym::class);
        $this->app->bind('Definition', Definition::class);
    }
}
