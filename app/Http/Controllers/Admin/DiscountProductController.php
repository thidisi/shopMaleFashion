<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NameStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DiscountProductController extends Controller
{
    /**
     * Construct
     */
    public function __construct(DiscountProduct $discountProduct, Production $product, Discount $discount)
    {
        $this->discountProduct = $discountProduct;
        $this->product = $product;
        $this->discount = $discount;
    }


    public function index()
    {
        try {
            $discountProducts = $this->discountProduct->leftJoin('productions', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->get([
                    'productions.name as product_name',
                    'discounts.discount_price as discount_price',
                    'discounts.date_end as date_end',
                    'discount_product.*'
                ]);
            return view('backend.discountProducts.index', [
                'discountProducts' => $discountProducts,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function create()
    {
        try {
            $products = $this->product->get();
            $discounts = $this->discount->where('status', \App\Models\Discount::DISCOUNT_STATUS['ACTIVE'])->get();

            return view('backend.discountProducts.create', [
                'products' => $products,
                'discounts' => $discounts,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function edit(DiscountProduct $discountProduct)
    {
        try {
            $products = $this->product->get();
            $discounts = $this->discount->where('status', \App\Models\Discount::DISCOUNT_STATUS['ACTIVE'])->get();

            return view('backend.discountProducts.edit', [
                'products' => $products,
                'discounts' => $discounts,
                'each' => $discountProduct,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function store(Request $request)
    {
        try {
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
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            $this->discountProduct->insert($data);
            return redirect()->route('admin.discountProducts')->with('addDiscountProductStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function update(Request $request, $discountProductId)
    {
        try {
            $discountProduct = $this->discountProduct->find($discountProductId);
            $arr = $request->validate([
                'production_id' => [
                    'required',
                    'unique:productions,id,' . $discountProduct->production_id
                ],
                'discount_id' => 'required|exists:discounts,id',
            ]);
            $discountProduct->update($arr);
            return redirect()->route('admin.discountProducts')->with('editDiscountProductStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function destroy($discountProductId)
    {
        DiscountProduct::destroy($discountProductId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
