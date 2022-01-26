<?php

namespace App\Providers;

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
        /**
         *
         * Force all connection to use https instead of either http or https
         * mostly configure at Cloudflare or your server. So just leave here as note
         *
         */
        // if($this->app->environment('production')) {
        //     \URL::forceScheme('https');
        // }
    }
}
