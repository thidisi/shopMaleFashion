<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountProduct;
use App\Models\District;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Production;
use App\Models\Province;
use App\Models\Ticket;
use App\Models\Ward;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Construct
     */
    public function __construct(Order $order, ProductImage $productImage, DiscountProduct $discountProduct, Province $province, District $district, Ward $ward, Ticket $ticket, Production $production)
    {
        $this->order = $order;
        $this->productImage = $productImage;
        $this->discountProduct = $discountProduct;
        $this->ward = $ward;
        $this->production = $production;
        $this->ticket = $ticket;
    }

    public function index()
    {
        $orders = $this->order->with('customers')->latest('created_at')->get();
        $date = Carbon::now()->addDays(7);
        $orders->map(function ($query) use ($date) {
            if ($query->action == 'inactive'  && $date == now()) {
                DB::table('order_detail')
                    ->where('order_id', '=', $query->id)
                    ->update(['deleted_at' => now()]);
                $this->order->find($query->id)->delete();
            }
            $query->total_money = currency_format($query->total_money);
            return $query;
        });

        return view('backend.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $order = $this->order->with(['tickets', 'productions'])->findOrFail($id);
        $order->productions->map(function ($query) {
            $query->image = json_decode($this->productImage->find($query->id)->image)[0];
            if (!empty($query->discount)) {
                $query->discount = $this->discountProduct->with('discounts')->find($query->id)->discounts;
            }
            $query->price = currency_format($query->price);
            return $query;
        });
        return view('backend.orders.show', [
            'order' => $order,
        ]);
    }

    public function action(Request $request, $action)
    {
        try {
            $orders = $this->order->findOrFail($request->id);
            if ($action == 'active') {
                foreach ($orders->productions as $value) {
                    $value->quantity -= $value->pivot->quantity;
                    $value->save();
                }
            } elseif (!empty($orders->ticket_id)) {
                $ticket = $this->ticket->find($orders->ticket_id);
                $ticket->status = 'pending';
                $ticket->save();
            }
            $orders->update(["action" => "$action"]);
            return redirect()->route('admin.orders')->with('UpdateOrderSuccess', 'Update successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function check_out(Request $request)
    {
        try {
            $order = $request->all();
            $order['address_receiver'] =  $this->ward->findOrFail($order['wards'])->path;
            $discount = $order['get_discount'];
            $code = $order['get_code'];

            unset($order['_token'], $order['get_code'], $order['provinces'], $order['districts'], $order['wards'], $order['get_total'], $order['get_discount']);

            if (!empty(Cart::getTotal())) {
                $order['customer_id'] = session('sessionIdCustomer');
                $order['total_money'] = Cart::getTotal() - $discount;
                $order['action'] = Order::ORDER_STATUS['PENDING'];
                $order_id = $this->order->create($order)->id;
                $cartItems = Cart::getContent();
                $pattern = "/\(.*\)/";
                $orders = $this->order->findOrFail($order_id);
                if ($code != null) {
                    $ticket = $this->ticket->where('code', $code)->first();
                    $ticket->quantity = $ticket->quantity - 1;
                    $ticket->status = 'active';
                    $ticket->save();
                    $orders->ticket_id = $ticket->id;
                    $orders->save();
                }
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
                        $product = $this->production->find($key);
                        $product->count_view += $value;
                        $product->save();
                    }
                }
                Cart::clear();
                return redirect()->route('index')->with('success', 'Orders successfully!!');
            }
            return redirect()->back()->with('error', "Empty stock, can't order");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Empty stock, can't order");
        }
    }

    public function get_discount(Request $request)
    {
        try {
            $tickets = $this->ticket->where('quantity', '>', 0)->where('status', '!=', 'suspended')->where('code', $request->discount)->firstOrFail();
            if ($tickets->status == 'active') {
                return response()->json([
                    'data' => 'Mã giảm giá của bạn đã sử dụng!'
                ], 401);
            }
            $data = [
                'discount' => currency_format($tickets->price),
                'slug' => $tickets->price,
                'code' => $tickets->code
            ];
            return response()->json([
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => 'Mã giảm giá không tồn tại!'
            ], 404);
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
