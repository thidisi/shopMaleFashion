<?php

namespace App\Providers;

use App\Enums\MenuStatusEnum;
use App\Enums\NameStatusEnum;
use App\Models\About;
use App\Models\Discount;
use App\Models\DiscountProduct;
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

        Discount::where('date_end', '<', now())->update([
            'status' =>  \App\Models\Discount::DISCOUNT_STATUS['CLOSE']
        ]);

        DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->where('discounts.status', \App\Models\Discount::DISCOUNT_STATUS['CLOSE'])->delete();
            
        // DiscountProduct::where('status', NameStatusEnum::NOT_ACTIVE)->delete();

        // DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.date_end', '<', now())
        //     ->update([
        //         'discount_product.status' => NameStatusEnum::NOT_ACTIVE
        //     ]);
        // DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.date_end', '>', now())
        //     ->update([
        //         'discount_product.status' => NameStatusEnum::ACTIVE
        //     ]);
        // DiscountProduct::where('status', NameStatusEnum::NOT_ACTIVE)->delete();

        view()->share([
            'menus' => $menus,
            'about' => $about,
        ]);
    }
}
