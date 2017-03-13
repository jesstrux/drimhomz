<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
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
        $res_url = asset("images/uploads/") . "/";
        View::share([
            'res_url' => $res_url,
            'user_url' => $res_url . "user_dps/",
            'house_url' => $res_url . "houses/",
            'banner_url' => $res_url . "banners/",
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
