<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NameStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $header = Auth::id();
        // $dd =  DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.status', \App\Models\Discount::DISCOUNT_STATUS['CLOSE'])->get();
        // dd($dd);
        // DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.date_end', '<', now())
        //     ->update([
        //         'discount_product.status' => NameStatusEnum::NOT_ACTIVE
        // //     ]);
        // DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.date_end', '>', now())
        //     ->oldest('discounts.date_end')
        //     ->get();
        // $show_reviews = $comments->show_reviews(1);

        // return $show_reviews;

        return view('backend.dashboards.index');
    }
}
