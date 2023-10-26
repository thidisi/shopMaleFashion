<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Construct
     */
    public function __construct(Customer $customer, Order $order,)
    {
        $this->customer = $customer;
        $this->order = $order;
    }
    public function index()
    {
        $customers_total = $this->customer->count();
        $order_total = $this->order->count();
        $sale_total = $this->order->where('action', 'active')->sum('total_money');
        $sale_total = currency_format($sale_total);
        $order_months = Order::select(
            DB::raw('SUM(total_money) as subtotal'),
            DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
        )->whereYear('created_at', date('Y'))
            ->where('action', 'active')
            ->groupBy('month')->get();
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($order_months as $order) {
            $data[$order->month] = $order->subtotal;
        }
        return view('backend.dashboards.index');
    }

    public function api_dashboad(Request $request)
    {
        if ($request->ajax()) {
            $customers_total = $this->customer->count();
            $orders_total = $this->order->count();
            $sales_total = $this->order->where('action', 'active')->sum('total_money');
            $order_months = Order::select(
                DB::raw('SUM(total_money) as subtotal'),
                DB::raw("EXTRACT(MONTH FROM `created_at`) as month")
            )->whereYear('created_at', date('Y'))
                ->where('action', 'active')
                ->groupBy('month')->get();
            $data_sale_months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            foreach ($order_months as $order) {
                $data_sale_months[$order->month] = $order->subtotal;
            }

            $orders_latest = $this->order->with('customers')->latest('created_at')->take(5)->get();
            $orders_latest->map(function ($query) {
                $query->total_money = currency_format($query->total_money);
                $query->url = route('admin.orders.show', $query->id);
                $query->date_format = date('H:i:s d/m/Y', strtotime($query->created_at));
                return $query;
            });
            return response()->json([
                'customers_total' => $customers_total,
                'orders_total' => $orders_total,
                'sales_total' => currency_format($sales_total),
                'data_sale_months' => $data_sale_months,
                'orders_latest' => $orders_latest
            ], 200);
        }else {
            abort(404);
        }
    }
}
