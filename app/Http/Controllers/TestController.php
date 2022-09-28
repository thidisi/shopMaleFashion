<?php

namespace App\Http\Controllers;

use App\Enums\NameAttrEnum;
use App\Enums\NameStatusEnum;
use App\Http\Controllers\Admin\CommentController;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\Major_Category;
use App\Models\Production;
use App\Models\Slide;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function test(Request $request, CommentController $comments)
    {
        // dd(Storage::disk('public')->exists(''));
        $show_reviews = $comments->show_comments(1);

        dd($show_reviews);

        // $body = "<div class='border border-secondary p-3' style='font-size: 1rem;color: black;'>
        //     <p><em>Hello ,</em></p>
        //     <p><em>
        //     We received a request to reset your account password for this email address. To begin the process of resetting your account's password, click on the code below.&nbsp;</em></p>
        //     <p><em>Code: </em></p>
        //     <p><em>Thank you !.<br>
        //     Shop Male Fashion;<br>
        //     </em></p></div>";

        // dd($body);
        // dd($reviews);

        // return DB::getSchemaBuilder()->getColumnListing('abouts');
        // $products = Production::query()->get();

        // $majorCategories = Major_Category::query()->get();
        // dd($majorCategories);


        // $grouped = $infos->groupBy('product_id');
        // $grouped->toArray();

        // foreach ($products as $each) {
        //     $each->status = $each->status_name;
        //     $each['info'] = $grouped[$each->id];
        //     dd($each);
        // }



        //get Date diff as intervals 

        // function dateDiffInDays($date1, $date2) 
        // {
        //     $diff = strtotime($date2) - strtotime($date1);
        //     return abs(round($diff / 86400));
        // }

        // diffInSeconds
        // // Start date
        // $date1 = "2022-08-11 04:03:00";
        // // // // End date
        // $date2 = now();

        // $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $date1);
        // $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $date2);

        // $days = $startDate->diffInDays($endDate);
        // $hours = $startDate->copy()->addDays($days)->diffInHours($endDate);
        // $minutes = $startDate->copy()->addDays($days)->addHours($hours)->diffInMinutes($endDate);
        // $seconds = $startDate->copy()->addDays($days)->addHours($hours)->addHours($minutes)->diffInSeconds($endDate);

        // // $seconds = $startDate->diffInSeconds($endDate);
        // dd($seconds);

        // $category = Discount::with('discount_product')->where('date_end', '<', now())->update([
        //     'status' => NameStatusEnum::NOT_ACTIVE
        // ]);
        // foreach ($category as $each){
        //     $data[] = $each->discount_product ;
        // }
        // foreach($data as $value){
        //     $value->status = NameStatusEnum::NOT_ACTIVE;
        //     $category->update();
        // }

        // return $category;



        // $users = Discount::whereHas('discount_product', function($q){
        //     $q->where('date_end', '<', now());
        // })->get();

        // return $users;

        //    $pro = Production::query()->find(1);
        //    $slug = Str::slug($pro->name, '-');
        //    dd($slug);
        // 




        // echo date("d-M-Y", strtotime($date)) . "\n";



    }

    // public function check(Request $request)
    // {
    //     $arr = [];
    //     if ($request->customer_id !== null) {
    //         $arr['customer_id'] = $request->customer_id;
    //     }
    //     $arr['parent_id'] = $request->parent_id ? $request->parent_id : null;
    //     $arr['content'] = $request->review_content;
    //     $arr['status'] = NOT_ACTIVE;
    //     $id = Comment::create($arr)->id;

    //     $comments = Comment::find($id);
    //     $product_id = $request->product_id;
    //     $review = $request->ratings;
    //     $images = null;

    //     if ($request->hasFile('images')) {
    //         $images = $request->file('images');
    //         foreach ($images as $image) {
    //             $path = Storage::disk('public')->put('imageReviews', $image);
    //             $data[] = $path;
    //         }
    //         $images = json_encode($data);
    //     }
    //     $comments->productions()->attach(
    //         [
    //             $product_id => ['review' => $review, 'images' => $images],
    //         ]
    //     );
    // }
}
