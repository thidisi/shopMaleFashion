<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NameStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(CommentController $comments)
    {
        // DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
        //     ->where('discounts.date_end', '<', now())
        //     ->update([
        //         'discount_product.status' => NameStatusEnum::NOT_ACTIVE
        //     ]);
        DiscountProduct::leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->where('discounts.date_end', '>', now())
            ->oldest('discounts.date_end')
            ->get();
        // $show_reviews = $comments->show_reviews(1);

        // return $show_reviews;

        return view('backend.dashboards.index');
    }
}
