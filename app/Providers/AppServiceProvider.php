<?php

namespace App\Providers;

use App\Enums\MenuStatusEnum;
use App\Enums\NameStatusEnum;
use App\Models\About;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Major_Category;
use App\Models\Notify;
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

        $discount = Discount::where('date_end', '<', now());
        if (count($discount->where('status', \App\Models\Discount::DISCOUNT_STATUS['ACTIVE'])->get()) > 0) {
            foreach ($discount->get() as $each) {
                $discount_prices[] = $each->discount_price . '%';
                $discount_getId[] = json_encode((object)['id' =>  $each->id]);
                $discount_id[] = $each->id;
            }
            $discount_price = implode(",", $discount_prices);
            $notify_discount['title'] = "Mã giảm giá($discount_price) đã hết thời hạn.";
            $notify_discount['discounts'] = $discount_getId;
            $notify_discount['type'] = 'Thông báo';
            Notify::create($notify_discount);
            $discount->update(['status' =>  \App\Models\Discount::DISCOUNT_STATUS['CLOSE']]);
            $discountProduct = DiscountProduct::whereIn('discount_id', $discount_id);
            if (count($discountProduct->get()) > 0) {
                foreach ($discountProduct->get() as $each) {
                    $production_getId[] = json_encode((object)['id' =>  $each->production_id]);
                    $discount_setId[] = json_encode((object)['id' =>  $each->discount_id]);
                }
                $notify_discountProduct['title'] = "Sản phẩm giảm giá hết thời hạn đã bị xóa!";
                $notify_discountProduct['products'] = $production_getId;
                $notify_discountProduct['discounts'] = $discount_setId;
                $notify_discountProduct['type'] = 'Thông báo';
                Notify::create($notify_discountProduct);
            }
        }
        view()->share([
            'menus' => $menus,
            'about' => $about,
        ]);
    }
}
