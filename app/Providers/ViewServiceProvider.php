<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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

        View::composer(
            'CP.layouts.header-footer', 'App\Http\ViewComposers\ControlPanelSideBar'
        );

        View::composer(
            'Client.layouts.app', 'App\Http\ViewComposers\ClientApp'
        );

        View::composer(
            'main.posts.sidebar', 'App\Http\ViewComposers\MainPostSideBar'
        );
    }
}
