<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DiscountPriceEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Construct
     */
    public function __construct(Discount $discount, DiscountProduct $discountProduct)
    {
        $this->discount = $discount;
        $this->discountProduct = $discountProduct;
    }

    public function index()
    {
        $discounts = $this->discount->latest('created_at')->get();
        foreach ($discounts as $each) {
            $each->date_start = $each->format_date_start;
            $each->date_end = $each->format_date_end;
        }
        return view('backend.discounts.index', [
            'discounts' => $discounts,
        ]);
    }

    public function create()
    {
        $promotions = DiscountPriceEnum::getValues();
        return view('backend.discounts.create', [
            'promotions' => $promotions
        ]);
    }

    public function edit(Discount $discount)
    {
        $promotions = DiscountPriceEnum::getValues();
        return view('backend.discounts.edit', [
            'each' => $discount,
            'promotions' => $promotions
        ]);
    }

    public function store(StoreDiscountRequest $request)
    {
        try {
            $date_start = $request->date_start;
            $date_start = date_format(date_create_from_format('j-M-Y', $date_start), 'Y-m-d');
            $date_end = $request->date_end;
            $date_end = date_format(date_create_from_format('j-M-Y', $date_end), 'Y-m-d');
            $arr['date_start'] = $date_start;
            $arr['date_end'] = $date_end;
            $arr['discount_price'] = $request->discount_price;
            $this->discount->create($arr);
            return redirect()->route('admin.discounts')->with('addDiscountStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function update(UpdateDiscountRequest $request, $discountId)
    {
        try {
            $discount = $this->discount->findOrFail($discountId);
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $discount->date_start = date_format(date_create_from_format('j-M-Y', $date_start), 'Y-m-d');
            $discount->date_end = date_format(date_create_from_format('j-M-Y', $date_end), 'Y-m-d');
            $discount->discount_price = $request->discount_price;
            $discount->status = $request->status ? \App\Models\Discount::DISCOUNT_STATUS['ACTIVE'] : \App\Models\Discount::DISCOUNT_STATUS['CLOSE'];
            $discount->save();
            return redirect()->route("admin.discounts")->with('EditDiscountStatus', 'Edit successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function destroy($discountId)
    {
        try {
            $this->discount->destroy($discountId);
            $this->discountProduct->where('discount_id', $discountId)->delete();
            return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }
}
