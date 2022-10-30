<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\DiscountProduct;
use App\Models\District;
use App\Models\Major_Category;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Production;
use App\Models\Province;
use App\Models\Ward;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    private object $model;
    /**
     * Construct
     */
    public function __construct(Order $order, ProductImage $productImage, DiscountProduct $discountProduct, Province $province, District $district, Ward $ward)
    {
        $this->order = $order;
        $this->productImage = $productImage;
        $this->discountProduct = $discountProduct;
        $this->ward = $ward;
    }

    public function index()
    {
        $orders = $this->order->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
            ->latest('orders.created_at')
            ->get(['customers.name as customerName', 'orders.*']);

        $date = Carbon::now()->addDays(10);
        foreach ($orders as $order) {
            if ($order->action == CANCEL && $date == now()) {
                DB::table('order_detail')
                    ->where('order_id', '=', $order->id)
                    ->update(['deleted_at' => now()]);
                $this->model->where('id', '=', $order->id)->delete();
            }
        }

        return view('backend.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        foreach ($order->productions as $value) {
            $value['image'] = $this->productImage->where('production_id', '=', $value->id)->get();
            $value['discount'] = $this->discountProduct->leftJoin('productions', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->where('discount_product.status', '=', ACTIVE)
                ->where('productions.id', '=', $value->id)
                ->get('discounts.discount_price as discount_price');
        }

        return view('backend.orders.show', [
            'orders' => $order->productions,
            'total' => $order->total_money,
            'order' => $order,
        ]);
    }

    public function action(Request $request, $action)
    {
        $orders = $this->order->find($request->id);
        if ($action == ACTIVE) {
            foreach ($orders->productions as $value) {
                $value->quantity -= $value->pivot->quantity;
                $value->save();
            }
        }
        $orders->update(["action" => "$action"]);

        return redirect()->route('admin.orders')->with('UpdateOrderSuccess', 'Update successfully!!');
    }

    public function check_out(Request $request)
    {
        
        try {
            $order = $request->all();
            $order['address_receiver'] =  $this->ward->findOrFail($order['wards'])->path;
            unset($order['_token'], $order['provinces'], $order['districts'], $order['wards']);

            if (!empty(Cart::getTotal())) {
                $order['customer_id'] = session('sessionIdCustomer');
                $order['total_money'] = Cart::getTotal();
                $order['action'] = NOT_ACTIVE;
                $order_id = $this->order->create($order)->id;
                $cartItems = Cart::getContent();
                $pattern = "/\(.*\)/";
                $orders = $this->order->find($order_id);

                foreach ($cartItems as $each) {
                    if (preg_match_all($pattern, $each->name, $matches)) {
                        foreach ($matches as $value) {
                            $dataAttr["$each->id"] = trim($value['0'], "()");
                        }
                    }
                    $orders->productions()->attach(
                        [
                            $each->id => ['quantity' => $each->quantity, 'attr' => $dataAttr["$each->id"]],
                        ]
                    );
                    $productId["$each->id"] = $each->quantity;
                }
                if (!empty($productId)) {
                    foreach ($productId as $key => $value) {
                        $product = Production::find($key);
                        $product->count_view += $value;
                        $product->save();
                    }
                }
                Cart::clear();
                return redirect()->route('index')->with('success', 'Orders successfully!!');
            }
            return redirect()->back()->with("Empty stock, can't order");
        } catch (\Throwable $th) {
            return view('frontend.errors.index');
        }
    }

    public function order_detail()
    {
        $order_details = $this->order->with('productions')->where('customer_id', session('sessionIdCustomer'))->latest()->get();
        foreach ($order_details as $value) {
            foreach ($value->productions as $each) {
                $images = $this->productImage->where('production_id', '=', $each->id)->first();
                $each['image'] = json_decode($images->image)[0];
            }
        }

        return view('frontend.orders.detail', [
            'order_details' => $order_details,
        ]);
    }
}