<?php

namespace App\Providers;

use App\Http\View\Composer\CartComposer;
use App\Http\View\Composer\NotiComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['*'], NotiComposer::class);
    }
}
