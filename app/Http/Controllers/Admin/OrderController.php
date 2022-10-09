<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\DiscountProduct;
use App\Models\Major_Category;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Production;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Order::query();
        $this->table = (new Order)->getTable();
    }

    public function index()
    {
        $orders = Order::leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
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
            $value['image'] = ProductImage::where('production_id', '=', $value->id)->get();
            $value['discount'] = DiscountProduct::leftJoin('productions', 'productions.id', '=', 'discount_product.production_id')
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
        $orders = $this->model->find($request->id);
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
        $order = $request->validate([
            'name_receiver' => 'required',
            'address_receiver' => 'required',
            'phone_receiver' => 'required',
            'note' => 'nullable',
        ]);

        if (!empty(Cart::getTotal())) {
            $order['customer_id'] = session('sessionIdCustomer');
            $order['total_money'] = Cart::getTotal();
            $order['action'] = NOT_ACTIVE;

            $order_id = $this->model->create($order)->id;

            $cartItems = Cart::getContent();
            $pattern = "/\(.*\)/";

            $orders = Order::find($order_id);

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

        return redirect()->back();
    }

    public function order_detail()
    {
        $order_details = Order::with('productions')->where('customer_id', session('sessionIdCustomer'))->latest()->get();
        foreach ($order_details as $value) {
            foreach ($value->productions as $each) {
                $images = ProductImage::where('production_id', '=', $each->id)->first();
                $each['image'] = json_decode($images->image)[0];
            }
        }

        return view('frontend.orders.detail', [
            'order_details' => $order_details,
        ]);
    }
}
