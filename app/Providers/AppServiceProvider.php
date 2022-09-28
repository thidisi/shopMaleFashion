<?php

namespace App\Providers;

use App\Enums\MenuStatusEnum;
use App\Models\About;
use App\Models\Major_Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        $menus = Major_Category::where('status', '=', MenuStatusEnum::SHOW)
            ->orWhere('status', '=', MenuStatusEnum::HOT_DEFAULT)
            ->get();
        $about = About::query()->first();

        view()->share([
            'menus' => $menus,
            'about' => $about,
        ]);
    }
}
