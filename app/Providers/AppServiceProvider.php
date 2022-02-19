<?php

namespace App\Providers;

use App\Channels\DatabaseChannel;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Blade::withoutComponentTags();

        Paginator::useBootstrap();

        Schema::defaultStringLength(191);

        /**
         * Register Custom Migration Paths
         */
        $this->loadMigrationsFrom([
            database_path('migrations'),
            database_path('migrations/updates'),
        ]);

        $this->app->instance(IlluminateDatabaseChannel::class, new DatabaseChannel);
    }
}
