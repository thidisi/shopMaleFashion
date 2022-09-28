<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DiscountPriceEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Discount::query();
        $this->table = (new Discount)->getTable();
    }

    public function index()
    {   
        $discounts = $this->model->get();
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
        $date_start = $request->input('date_start');
        $date_start = date_format(date_create_from_format('j-M-Y', $date_start), 'Y-m-d');
        $date_end = $request->input('date_end');
        $date_end = date_format(date_create_from_format('j-M-Y', $date_end), 'Y-m-d');

        $arr = $request->validated();
        $arr['date_start'] = $date_start;
        $arr['date_end'] = $date_end;

        $this->model->create($arr);
        return redirect()->route('admin.discounts')->with('addDiscountStatus', 'Add successfully!!');
    }

    public function update(UpdateDiscountRequest $request, $discountId)
    {
        $discounts = $this->model->find($discountId);
        
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $discounts->date_start = date_format(date_create_from_format('j-M-Y', $date_start), 'Y-m-d');
        $discounts->date_end = date_format(date_create_from_format('j-M-Y', $date_end), 'Y-m-d');
        $discounts->discount_price = $request->input('discount_price');
        $discounts->update();
        return redirect()->route("admin.discounts")->with('EditDiscountStatus', 'Edit successfully!!');
    }

    public function destroy($discountId)
    {
        Discount::destroy($discountId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
