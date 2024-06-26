<?php

namespace App\Providers;

use App\Core\CustomResourceRegistrar;
use App\Models\Ads;
use App\Models\City;
use App\Models\Page;
use App\Models\RecommendedLink;
use App\Models\Setting;
use App\Models\Stat;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

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

        $recommendedLinks = RecommendedLink::whereStatus(1)->take(4)->get();
        View::share('recommendedLinks', $recommendedLinks);
        $cities = City::all();
        View::share('cities', $cities);

        $pages = Page::whereIn('id', [1, 2,3])->get();
        View::share('pages', $pages);

        $loginImages = Ads::whereStatus(1)->where('type', 6)->get();
        View::share('loginImages', $loginImages);
        Paginator::useBootstrapFour();
    }
}
