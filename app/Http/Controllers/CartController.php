<?php

namespace App\Http\Controllers;

use App\Enums\MenuStatusEnum;
use App\Models\About;
use App\Models\Customer;
use App\Models\Major_Category;
use App\Models\Production;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $menus = Major_Category::where('status', '=', MenuStatusEnum::SHOW)
            ->orWhere('status', '=', MenuStatusEnum::HOT_DEFAULT)
            ->get();
        $cartItems = Cart::getContent();

        $checkCart = Cart::isEmpty();
        $customer = Customer::query()->find(session('sessionIdCustomer'));
        $about = About::query()->first();
        return view('frontend.carts.index', [
            'menus' => $menus,
            'cartItems' => $cartItems,
            'checkCart' => $checkCart,
            'customer' => $customer,
            'about' => $about,
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = Production::find($request->id);
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
        $product = Production::find($request->id);
        $checkQuantity = $product->quantity - $request->quantity;
        if ($checkQuantity >= 0) {
            Cart::update($request->id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
            return response('Update sản phẩm thành công!', 200);
        } else {
            return response('Sản phẩm bạn vừa thêm đã hết hàng rồi!', 299);
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
