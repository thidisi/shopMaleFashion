<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountProductRequest;
use App\Http\Requests\UpdateDiscountProductRequest;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Production;
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
            $discountProducts = $this->discountProduct->with(['productions', 'discounts'])->get();
            $discountProducts->each(function ($query) {
                $query->product_name = $query->productions->name;
                $query->discount_price = $query->discounts->discount_price;
                $query->date_end = $query->discounts->date_end;
            });
            return view('backend.discountProducts.index', [
                'discountProducts' => $discountProducts,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function create()
    {
        try {
            $discounts = $this->discount->where('status', Discount::DISCOUNT_STATUS['ACTIVE'])->get();
            $discountProducts = $this->discountProduct->get('production_id');
            $existsDiscountProduct = [];
            foreach ($discountProducts as $each) {
                $existsDiscountProduct[] = $each->production_id;
            }
            $products = $this->product->whereNotIn('id', $existsDiscountProduct)->get();

            return view('backend.discountProducts.create', [
                'products' => $products,
                'discounts' => $discounts,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function edit(DiscountProduct $discountProduct)
    {
        try {
            $discounts = $this->discount->where('status', \App\Models\Discount::DISCOUNT_STATUS['ACTIVE'])->get();
            $discountProducts = $this->discountProduct->whereNotIn('id', [$discountProduct->id])->get('production_id');
            $existsDiscountProduct = [];
            foreach ($discountProducts as $each) {
                $existsDiscountProduct[] = $each->production_id;
            }
            $products = $this->product->whereNotIn('id', $existsDiscountProduct)->get();
            return view('backend.discountProducts.edit', [
                'products' => $products,
                'discounts' => $discounts,
                'each' => $discountProduct,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function store(StoreDiscountProductRequest $request)
    {
        try {
            $arr = $request->all();
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
            return redirect()->route('errors');
        }
    }

    public function update(UpdateDiscountProductRequest $request, $discountProductId)
    {
        try {
            $discountProduct = $this->discountProduct->find($discountProductId);
            $arr = $request->all();
            $discountProduct->update($arr);
            return redirect()->route('admin.discountProducts')->with('editDiscountProductStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function destroy($discountProductId)
    {
        DiscountProduct::destroy($discountProductId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
