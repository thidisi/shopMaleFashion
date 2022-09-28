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
    public function errors()
    {
        $menus = Major_Category::where('status', '=', MenuStatusEnum::SHOW)
            ->orWhere('status', '=', MenuStatusEnum::HOT_DEFAULT)
            ->get();
        $about = About::query()->first();
        return view('errors.404', [
            'menus' => $menus,
            'about' => $about
        ]);
    }

    public function check_cookies()
    {
        $check_cookie = Cookie::get('remember');
        if (!empty($check_cookie)) {
            $customer = Customer::query()->where('token', $check_cookie)->first();
            session()->put('sessionEmailCustomer', $customer->email);
            session()->put('sessionIdCustomer', $customer->id);
            session()->put('sessionCustomerName', $customer->name);
        }
    }
    
    public function index()
    {
        self::check_cookies();
        $menus = Major_Category::where('status', '=', MenuStatusEnum::SHOW)
            ->orWhere('status', '=', MenuStatusEnum::HOT_DEFAULT)
            ->get();
        $slides = Slide::leftJoin('major_categories', 'slide.major_category_id', '=', 'major_categories.id')
            ->where('slide.sort_order', '=', SortOrderSlideEnum::SLIDER)
            ->where('slide.status', '=', NameStatusEnum::ACTIVE)
            ->get(['major_categories.slug as menu_slug', 'slide.*']);

        $banners = Slide::leftJoin('major_categories', 'slide.major_category_id', '=', 'major_categories.id')
            ->where('slide.sort_order', '=', SortOrderSlideEnum::BANNER)
            ->where('slide.status', '=', NameStatusEnum::ACTIVE)
            ->get(['major_categories.slug as menu_slug', 'slide.*']);

        $instagram = Slide::leftJoin('major_categories', 'slide.major_category_id', '=', 'major_categories.id')
            ->where('slide.sort_order', '=', SortOrderSlideEnum::INSTAGRAM)
            ->where('slide.status', '=', NameStatusEnum::ACTIVE)
            ->get(['major_categories.slug as slug', 'slide.*']);

        $blogs = Blog::where('status', '=', NameStatusEnum::ACTIVE)
            ->latest('created_at')
            ->paginate(3);

        $discountProduct = DiscountProduct::leftJoin('productions', 'productions.id', '=', 'discount_product.production_id')
            ->rightJoin('product_images', 'productions.id', '=', 'product_images.production_id')
            ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->select(
                'productions.id as id',
                'discount_product.status as status',
                'productions.name as name',
                'productions.price as price',
                'product_images.image as image',
                'discounts.date_start as date_start',
                'discounts.date_end as date_end',
                'discounts.discount_price as discount_price',
            )
            ->where('discount_product.status', '=', NameStatusEnum::ACTIVE)
            ->where('discounts.date_end', '>', now())
            ->orderBy('discount_product.updated_at', 'asc')
            ->first();

        $products = Production::Join('product_images', 'productions.id', '=', 'product_images.production_id')
            ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
            ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
            ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->where('productions.status', '=', ACTIVE)
            ->latest('productions.count_view')
            ->select(
                'product_images.image as image',
                'product_images.status as statusImage',
                'categories.name as categoryName',
                'discounts.discount_price as discountPrice',
                'discount_product.status as statusDiscount',
                'productions.*'
            )->paginate(8);
        foreach ($products as $each) {
            $each->image = json_decode($each->image)[0];
            if ($each->statusDiscount == ACTIVE) {
                $each->discountPrice = (100 - $each->discountPrice) / 100;
            }
            $each['review'] = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
        }

        $about = About::query()->first();

        return view('frontend.home.index', [
            'menus' => $menus,
            'slides' => $slides,
            'banners' => $banners,
            'products' => $products,
            'instagram' => $instagram,
            'blogs' => $blogs,
            'discountProduct' => $discountProduct,
            'about' => $about,
        ]);
    }

    public function handleLogin(Request $request)
    {
        try {
            $customer = Customer::query()
                ->where('email', $request->emailUser)
                ->firstOrFail();
            if ($customer !== null) {
                $hasPassword = $customer->password;
                $password = $request->passwordUser;
                $token = Hash::make(uniqid('user_', true));
                $remember = null;
                if ($request->remember === 'true') {
                    $remember = $token;
                }
                if (Hash::check($password, $hasPassword)) {
                    if ($customer->status === ACTIVE) {
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
            $customer = Customer::query()->where('email', $request->get('emailReset'))->where('status', ACTIVE)->firstOrFail();
            $token = uniqid();

            $check = DB::table('forgot_password')->where('customer_id', $customer->id)->count();
            if ($check == 0) {
                DB::table('forgot_password')->insert([
                    'customer_id' => $customer->id,
                    'token' => $token
                ]);
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
                $users[]['email'] = $customer->email;
                SendEmail::dispatch($message, $users)->delay(now()->addMinute(1));
            }
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
