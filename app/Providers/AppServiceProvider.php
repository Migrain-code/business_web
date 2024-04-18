<?php

namespace App\Providers;

use App\Core\CustomResourceRegistrar;
use App\Models\City;
use App\Models\Setting;
use App\Models\Stat;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $registrar = new CustomResourceRegistrar($this->app['router']);

        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });

        foreach (Setting::all() as $item) {
            $settings[$item->name] = $item->value;
        }

        \Config::set('settings', $settings);

        $stats = Stat::where('status', 1)->select('title', 'percentage', 'icon')->get();
        View::share('stats', $stats);

        $cities = City::all();
        View::share('cities', $cities);
    }
}
