<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NameStatusEnum;
use App\Models\Discount;
use App\Http\Controllers\Controller;
use App\Models\DiscountProduct;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DiscountProductController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = DiscountProduct::query();
        $this->table = (new DiscountProduct)->getTable();
    }

    public function index()
    {

        $discountProducts = DiscountProduct::leftJoin('productions', 'productions.id', '=', 'discount_product.production_id')
            ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->get([
                'productions.name as product_name',
                'discounts.discount_price as discount_price',
                'discounts.date_end as date_end',
                'discount_product.*'
            ]);
        foreach ($discountProducts as $each) {
            $each->status = $each->status_name;
        }
        return view('backend.discountProducts.index', [
            'discountProducts' => $discountProducts,
        ]);
    }

    public function create()
    {
        $products = Production::query()->get();
        $discounts = Discount::query()->get();

        return view('backend.discountProducts.create', [
            'products' => $products,
            'discounts' => $discounts,
        ]);
    }

    public function edit(DiscountProduct $discountProduct)
    {
        $products = Production::query()->get();
        $discounts = Discount::query()->get();

        return view('backend.discountProducts.edit', [
            'products' => $products,
            'discounts' => $discounts,
            'each' => $discountProduct,
        ]);
    }

    public function store(Request $request)
    {
        $status = $request->input('status') ? '1' : '2';
        $discountProduct = $this->model->get();

        $arr = $request->validate([
            'production_id' => [
                'required',
                'unique:discount_product,production_id'
            ],
            'discount_id' => 'required|exists:discounts,id',
        ]);
        foreach ($arr['production_id'] as $each) {
            $data[] = [
                'production_id' => $each,
                'discount_id' => $arr['discount_id'],
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->model->insert($data);
        return redirect()->route('admin.discountProducts')->with('addDiscountProductStatus', 'Add successfully!!');
    }

    public function update(Request $request, $discountProductId)
    {
        $discountProduct = $this->model->find($discountProductId);
        $status = $request->input('status') ? '1' : '2';

        $arr = $request->validate([
            'production_id' => [
                'required',
                'unique:productions,id,' . $discountProduct->production_id
            ],
            'discount_id' => 'required|exists:discounts,id',
        ]);
        $arr['status'] = $status;

        $discountProduct->update($arr);
        return redirect()->route('admin.discountProducts')->with('editDiscountProductStatus', 'Add successfully!!');
    }

    public function destroy($discountProductId)
    {
        DiscountProduct::destroy($discountProductId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
