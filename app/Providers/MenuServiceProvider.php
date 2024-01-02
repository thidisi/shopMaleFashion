<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Major_Category;
use App\Services\NotifyService;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
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
        view()->composer('frontend.layouts', function ($view) {
            $notifyService = new NotifyService();

            $menus = Major_Category::query()->where('status', 'show')
                ->orWhere('status', 'hot_default')
                ->get();
            $about = About::query()->first();

            $discounts = Discount::where('date_end', '<', now())->where('status', Discount::DISCOUNT_STATUS['ACTIVE']);
            if (count($discounts->get()) > 0) {
                foreach ($discounts->get() as $each) {
                    $discount_prices[] = $each->discount_price . '%';
                    $discount_getId[] = json_encode((object)['id' =>  $each->id]);
                    $discount_id[] = $each->id;
                }
                $discount_price = implode(",", $discount_prices);
                $notify_discount['title'] = "Mã giảm giá($discount_price) đã hết thời hạn.";
                $notify_discount['discounts'] = $discount_getId;
                $notifyService->create($notify_discount);
                $discounts->update(['status' =>  Discount::DISCOUNT_STATUS['CLOSE']]);
                $discountProducts = DiscountProduct::whereIn('discount_id', $discount_id);
                if (count($discountProducts->get()) > 0) {
                    foreach ($discountProducts->get() as $each) {
                        $production_getId[] = json_encode((object)['id' =>  $each->production_id]);
                    }

                    foreach ($discount_id as $value) {
                        $discount_setId[] = json_encode((object)['id' =>  $value]);
                    }
                    $notify_discountProduct['title'] = "Sản phẩm giảm giá hết thời hạn đã bị xóa!";
                    $notify_discountProduct['products'] = $production_getId;
                    $notify_discountProduct['discounts'] = $discount_setId;
                    $discountProducts->delete();
                    $notifyService->create($notify_discountProduct);
                }
            }
            $view->with(['menus' => $menus, 'about' => $about]);
        });
    }
}
