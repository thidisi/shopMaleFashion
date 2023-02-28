<?php

namespace App\Http\Controllers;

use App\Enums\MenuStatusEnum;
use App\Models\About;
use App\Models\Customer;
use App\Models\District;
use App\Models\Major_Category;
use App\Models\Production;
use App\Models\Province;
use App\Models\Ward;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Construct
     */
    public function __construct(Production $product, Customer $customer, Province $province, District $district, Ward $ward)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
    }
    public function index()
    {
        $cartItems = Cart::getContent();

        $checkCart = Cart::isEmpty();
        $customer = $this->customer->find(session('sessionIdCustomer'));
        return view('frontend.carts.index', [
            'cartItems' => $cartItems,
            'checkCart' => $checkCart,
            'customer' => $customer,
        ]);
    }

    public function checkout()
    {
        try {
            $customer = $this->customer->findOrFail(session('sessionIdCustomer'));
            $cartItems = Cart::getContent();
            if(!Cart::isEmpty()){
                $data['getSubTotal'] = 0;
                foreach (Cart::getContent() as $value) {
                    $data['getSubTotal'] += ($value->price * $value->quantity);
                }
                $data['getSubTotal'] = $data['getSubTotal'];
                $data['getTotal'] = Cart::getTotal();
                return view('frontend.carts.checkout', [
                    'customer' => $customer,
                    'cartItems' => $cartItems,
                    'data' => $data
                ]);
            }
            return view('frontend.carts.checkoutNone');
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }

    public function getAddress()
    {
        $provinces = $this->province->with(['districts' => function ($query) {
            $query->with('wards');
        }])->get();
        return response()->json([
            'data' => $provinces
        ], 200);
    }

    public function addToCart(Request $request)
    {
        $product = $this->product->find($request->id);
        $checkQuantity = $product->quantity - $request->quantity;
        $productName = $request->name . ' (Size:' . $request->size . ', ' . $request->color . ')';
        $saleCondition = new \Darryldecode\Cart\CartCondition(array(
            'name' => "SALE $request->discount%",
            'type' => 'tax',
            'value' => "-$request->discount%",
        ));
        if (Cart::isEmpty()) {
            if ($checkQuantity >= 0) {
                Cart::add([
                    'id' => $request->id,
                    'name' => $productName,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'attributes' => array(
                        'image' => $request->image,
                        'discounts' => $request->discount,
                    ),
                    'conditions' => $saleCondition
                ]);
                return response('Thêm sản phẩm thành công!', 200);
            }
            return response('Sản phẩm bạn vừa thêm đã hết hàng rồi!', 299);
        } else {
            $cartItems = Cart::getContent();
            $dataId["$request->id"] = 0;
            foreach ($cartItems as $each) {
                $dataId["$each->id"] = $each->quantity;
            }
            $checkAddQuantity = $dataId["$request->id"] + $request->quantity;
            if ($checkAddQuantity <= 10) { // Check product quantity when adding
                $checkQ = $checkQuantity - $dataId["$request->id"];
                if ($checkQ >= 0) { // Check remaining product quantity
                    Cart::add([
                        'id' => $request->id,
                        'name' => $productName,
                        'price' => $request->price,
                        'quantity' => $request->quantity,
                        'attributes' => array(
                            'image' => $request->image,
                            'discounts' => $request->discount,
                        ),
                        'conditions' => $saleCondition
                    ]);
                    return response('Thêm sản phẩm thành công!', 200);
                } else {
                    return response('Sản phẩm bạn vừa thêm đã hết hàng rồi!', 299);
                }
            } else {
                return response('Sản phẩm bạn vừa thêm đã đạt giới hạn mua rồi!', 299);
            }
        }
    }

    public function updateCart(Request $request)
    {
        $product = $this->product->find($request->id);
        $checkQuantity = $product->quantity - $request->quantity;
        if ($checkQuantity >= 0) {
            Cart::update($request->id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
            $data['getSubTotal'] = 0;
            foreach (Cart::getContent() as $value) {
                $data['getSubTotal'] += ($value->price * $value->quantity);
            }
            $data['getSubTotal'] = currency_format($data['getSubTotal']);
            $data['getTotal'] = currency_format(Cart::getTotal());
            return response()->json([
                'message' => __("Update sản phẩm thành công!"),
                'data' => $data
            ], 200);
        } else {
            return response()->json(['message' => __("Sản phẩm bạn vừa thêm đã hết hàng rồi!")], 201);
        }
    }

    public function removeCart($cartId)
    {
        Cart::remove($cartId);
        return response('Xóa sản phẩm thành công!', 200);
    }

    public function clearAllCart()
    {
        Cart::clear();
        return redirect()->route('cart')->with('success', 'Clears successfully!!');
    }
}
