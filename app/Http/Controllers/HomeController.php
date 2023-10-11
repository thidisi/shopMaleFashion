<?php

namespace App\Http\Controllers;

use App\Enums\MenuStatusEnum;
use App\Enums\NameStatusEnum;
use App\Enums\SortOrderSlideEnum;
use App\Jobs\SendEmail;
use App\Models\About;
use App\Models\Blog;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Major_Category;
use App\Models\ProductImage;
use App\Models\Production;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function __construct(Customer $customer, Slide $slide, Blog $blog, Production $product, DiscountProduct $discountProduct, ProductImage $productImage, Discount $discount)
    {
        $this->customer = $customer;
        $this->slide = $slide;
        $this->blog = $blog;
        $this->product = $product;
        $this->discount = $discount;
        $this->discountProduct = $discountProduct;
        $this->productImage = $productImage;
    }

    public function errors()
    {

        return view('errors.404');
    }

    public function check_cookies()
    {
        $check_cookie = Cookie::get('remember');
        if (!empty($check_cookie)) {
            $customer = $this->customer->where('token', $check_cookie)->first();
            session()->put('sessionEmailCustomer', $customer->email);
            session()->put('sessionIdCustomer', $customer->id);
            session()->put('sessionCustomerName', $customer->name);
        }
    }

    public function index()
    {
        self::check_cookies();
        $slides = $this->slide->with('major_categories')->where('slide.status', '=', Slide::SLIDE_STATUS['ACTIVE'])->get();
        $slideOrders = Slide::SLIDE_ORDER;

        $blogs = $this->blog->where('status', '=', NameStatusEnum::ACTIVE)
            ->latest('created_at')
            ->paginate(3);

        $discountProduct = $this->discountProduct->with(['discounts', 'productions'])
            ->whereHas('discounts', function ($query) {
                $query->where('date_end', '>', now());
                $query->where('status', Discount::DISCOUNT_STATUS['ACTIVE']);
                $query->oldest('date_end');
            })
            ->whereHas('productions', function ($query) {
                $query->where('quantity', '>', 0);
            })
            ->first();
        $discountProduct->productImage = json_decode($this->productImage->where('production_id', $discountProduct->productions->id)->first(['id', 'image', 'status'])->image)[0];

        $products = $this->product->with(['categories', 'product_images', 'discount_products'])
            ->where('status', Production::PRODUCTION_STATUS['ACTIVE'])
            ->latest('created_at')->get();
        $products = $products->map(function ($query) {
            $query->image = json_decode($query->product_images->image)[0];
            $query->discount = 1;
            $query->discountStatus = Discount::DISCOUNT_STATUS['CLOSE'];
            if (!empty($query->discount_products)) {
                $query->discount = (100 - $this->discount->find($query->discount_products->discount_id)->discount_price) / 100;
                $query->discountStatus = Discount::DISCOUNT_STATUS['ACTIVE'];
            }
            $query->review = DB::table('production_comments')->where('production_id', '=', $query->id)->avg('review');
            return $query;
        });

        return view('frontend.home.index', [
            'slideOrders' => $slideOrders,
            'slides' => $slides,
            'products' => $products,
            'blogs' => $blogs,
            'discountProduct' => $discountProduct,
        ]);
    }

    public function handleLogin(Request $request)
    {
        try {
            $customer = Customer::query()
                ->where('email', $request->emailUser)
                ->firstOrFail();
            if ($customer != null) {
                $hasPassword = $customer->password;
                $password = $request->passwordUser;
                $token = Hash::make(uniqid('user_', true));
                $remember = null;
                if ($request->remember === 'true') {
                    $remember = $token;
                }
                if (Hash::check($password, $hasPassword)) {
                    if ($customer->status == 'active') {
                        $customer->token = $remember;
                        $customer->save();
                        $request->session()->put('sessionEmailCustomer', $customer->email);
                        $request->session()->put('sessionIdCustomer', $customer->id);
                        $request->session()->put('sessionCustomerName', $customer->name);
                        return response('Logged in successfully!', 200)->cookie('remember', $remember, 15);
                    }
                    return response('Your account has been locked!!', 404);
                }
                return response('Password does not exist!', 404);
            }
        } catch (\Throwable $e) {
            return response('Account does not exist!', 404);
        }
    }
    public function signUp(Request $request)
    {
        try {
            $request->validate([
                'email'     => 'required|unique:customers',
            ]);
            $password = Hash::make($request->password);
            $customer = Customer::query()
                ->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            return response('Create Account Success', 200);
        } catch (\Throwable $e) {
            return response('Your email already exists!', 404);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $customer = Customer::query()->where('email', $request->get('emailReset'))->where('status', 'active')->firstOrFail();
            $token = \Str::random(26);
            $check = DB::table('forgot_password')->where('customer_id', $customer->id)->count();
            if ($check != ACTIVE) {
                DB::table('forgot_password')->insert([
                    'customer_id' => $customer->id,
                    'token' => $token
                ]);
            } else {
                DB::table('forgot_password')->update([
                    'customer_id' => $customer->id,
                    'token' => $token
                ]);
            }
            $message = [
                'body' => "<div class='border border-secondary p-3' style='font-size: 1rem;color: black;'>
                <p><em>Hello $customer->name,</em></p>
                <p><em>
                We received a request to reset your account password for this email address. To begin the process of resetting your account's password, click on the code below.&nbsp;</em></p>
                <p><em>Code: $token</em></p>
                <p><em>Thank you !.<br>
                Shop Male Fashion;<br>
                </em></p></div>",
            ];
            $message['subject'] = "Shop ko biet dau";
            $users[]['email'] = $customer->email;
            // SendEmail::dispatch($message, $users)->delay(now()->addMinute(1));
            return response('Please check your email for the code!!', 200);
        } catch (\Throwable $e) {
            return response('Email does not exist or has been disabled!!', 404);
        }
    }

    public function changePassword(Request $request)
    {
        $check = DB::table('forgot_password')->where('token', $request->token)->first();
        $password = Hash::make($request->newPassword);
        if (!$check) {
            return response('Your token is not correct!!', 404);
        }
        Customer::find($check->customer_id)->update(['password' => $password]);
        DB::table('forgot_password')->where('token', $request->token)->delete();
        return response('You have successfully changed your password!!', 200);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Cookie::queue(Cookie::forget('remember'));
        return response('Sign out successful!', 200);
    }
}
