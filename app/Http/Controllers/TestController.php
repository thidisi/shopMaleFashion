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
        $data = ["PHP", "Java", "Python", "Ruby"];


        foreach ($data as $each) {
            $value[] = "<table cellpadding='0' cellspacing='0' align='left' style='margin-right: 6px'><tbody><tr><td style='padding: 0px 10px;border: 1px solid #f60;
                        font-size: 0.75rem;
                        border-radius: 3px;
                        color: #f60;
                        font-weight: 500;
                        background: hsla(14deg, 100%, 77%, 0.15);
                        text-transform: uppercase;'>
                        $each
                    </td></tr></tbody></table>";
        }

        $fe = implode("", $value);
        // $content = "<div class='border border-secondary p-3' style='font-size: 1rem;color: black;'>
        //         <ul>
        //         <li>$fe</li>
        //         </ul>
        //     </div>";


        return $fe;

        // $content = view('test2', [
        //     'data' => $data,
        // ]);
        //     $content = "<tr>
        //     <td style='padding:20px 26px' align='center' valign='top'>
        //         <table border='0' cellpadding='0' cellspacing='0' width='100%' align='center'>
        //             <tbody>
        //                 <tr>
        //                     <td align='left' style='background: hsla(14deg, 100%, 77%, 0.07);border-radius: 3px;
        //                                                   border: 1px solid hsla(14deg, 100%, 77%, 0.52);
        //                                                   border-left: 2px solid #f60;
        //                                                   padding: 12px;'>
        //                         <table border='0' cellpadding='0' cellspacing='0' width='100%' align='center'>
        //                             <tbody>
        //                                 <tr>
        //                                     <td align='left'>
        //                                         {{-- logo company --}}
        //                                         <table cellpadding='0' cellspacing='0' align='left'>
        //                                             <tbody>
        //                                                 <tr>
        //                                                     <td width='90' align='center'>
        //                                                         <table cellpadding='0' cellspacing='0' width='100%'>
        //                                                             <tbody>
        //                                                                 <tr>
        //                                                                     <td align='center'>

        //                                                                     </td>
        //                                                                 </tr>
        //                                                             </tbody>
        //                                                         </table>
        //                                                     </td>
        //                                                 </tr>
        //                                             </tbody>
        //                                         </table>
        //                                         {{-- end logo company  --}}
        //                                         <table cellpadding='0' cellspacing='0' align='right'>
        //                                             <tbody>
        //                                                 <tr>
        //                                                     <td width='409' align='left'>
        //                                                         <table cellpadding='0' cellspacing='0' width='100%'>
        //                                                             <tbody style='font-family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;'>
        //                                                                 {{-- name skill --}}
        //                                                                 <tr>
        //                                                                     <td align='left'>
        //                                                                         <h3 style='color:#f60;font-size: 0.95rem;font-weight: 600;
        //                                                                                                       margin-bottom: 10px;margin-top: 0;'>{{ $data['title'] }}</h3>
        //                                                                     </td>
        //                                                                 </tr>
        //                                                                 {{-- end name skill --}}
        //                                                                 {{-- skills --}}
        //                                                                 <tr>
        //                                                                     <td align='left'>
        //                                                                         @foreach( $data['skills'] as $value)
        //                                                                         <table cellpadding='0' cellspacing='0' align='left' style='margin-right: 8px;margin-bottom: 10px;'>
        //                                                                             <tbody>
        //                                                                                 <tr>
        //                                                                                     <td style='padding: 0px 10px;border: 1px solid #f60;
        //                                                                                                                   font-size: 0.75rem;
        //                                                                                                                   border-radius: 3px;
        //                                                                                                                   color: #f60;
        //                                                                                                                   margin-right: 8px;
        //                                                                                                                   font-weight: 500;
        //                                                                                                                   background: hsla(14deg, 100%, 77%, 0.15);
        //                                                                                                                   text-transform: uppercase;'>
        //                                                                                         {{ $value }}
        //                                                                                     </td>
        //                                                                                 </tr>
        //                                                                             </tbody>
        //                                                                         </table>
        //                                                                         @endforeach
        //                                                                     </td>
        //                                                                 </tr>
        //                                                                 {{-- end skills --}}
        //                                                                 {{-- infos --}}
        //                                                                 <tr>
        //                                                                     <td align='left'>
        //                                                                         <table cellpadding='0' cellspacing='0' align='left' style='margin-right: 8px;margin-bottom: 8px;'>
        //                                                                             <tbody>
        //                                                                                 <tr>
        //                                                                                     <td style='font-size: 0.75rem;                                                                                                                            margin-right: 8px;
        //                                                                                                                   font-weight: 500;
        //                                                                                                                   line-height: 23px;
        //                                                                                                                   text-transform: capitalize;'>
        //                                                                                         <img src='{{ asset('images/nha.png') }}' alt='>
        //                                                                                         <span>{{ $data['name_company'] }}</span>
        //                                                                                     </td>
        //                                                                                 </tr>
        //                                                                             </tbody>
        //                                                                         </table>
        //                                                                         <table cellpadding='0' cellspacing='0' align='left' style='margin-right: 8px;margin-bottom: 8px;'>
        //                                                                             <tbody>
        //                                                                                 <tr>
        //                                                                                     <td style='font-size: 0.75rem;
        //                                                                                                                   line-height: 23px;
        //                                                                                                                   font-weight: 500;
        //                                                                                                                   text-transform: capitalize;'>
        //                                                                                         <img src='{{ asset('images/vitri.png') }}' alt='>
        //                                                                                         <span>{{ $data['address'] }}</span>
        //                                                                                     </td>
        //                                                                                 </tr>
        //                                                                             </tbody>
        //                                                                         </table>
        //                                                                         <table cellpadding='0' cellspacing='0' align='left' style='margin-right: 8px;margin-bottom: 8px;'>
        //                                                                             <tbody>
        //                                                                                 <tr>
        //                                                                                     <td style='font-size: 0.75rem;
        //                                                                                                                   font-weight: 500;
        //                                                                                                                   line-height: 23px;
        //                                                                                                                   text-transform: capitalize;'>
        //                                                                                         <img src='{{ asset('images/tui.png') }}' alt='>
        //                                                                                         <span>{{ $data['timeline'] }}</span>
        //                                                                                     </td>
        //                                                                                 </tr>
        //                                                                             </tbody>
        //                                                                         </table>
        //                                                                     </td>
        //                                                                 </tr>
        //                                                                 {{-- end infos --}}
        //                                                                 {{-- descriptions --}}
        //                                                                 <tr>
        //                                                                     <td align='left'>
        //                                                                         <p style='margin-bottom: 16px;
        //                                                                                                   margin-top: 0;font-size: 14px;
        //                                                                                                   font-style: italic;color: #959090;font-weight: 300;
        //                                                                                                   overflow: hidden;
        //                                                                                                   text-overflow: ellipsis;
        //                                                                                                   display: -webkit-box;
        //                                                                                                   '>
        //                                                                             {{ $data['description'] }}
        //                                                                         </p>
        //                                                                     </td>
        //                                                                 </tr>
        //                                                                 {{-- end descriptions --}}
        //                                                             </tbody>
        //                                                         </table>
        //                                                     </td>
        //                                                 </tr>
        //                                             </tbody>
        //                                         </table>
        //                                     </td>
        //                                 </tr>
        //                             </tbody>
        //                         </table>
        //                         <table border='0' cellpadding='0' cellspacing='0' width='100%' align='center'>
        //                             <tbody>
        //                                 <tr>
        //                                     <td align='left'>
        //                                         <table cellpadding='0' cellspacing='0' align='left' width='100%'>
        //                                             <tbody>
        //                                                 <tr>
        //                                                     <td align='center'>
        //                                                         <table cellpadding='0' cellspacing='0' width='100%'>
        //                                                             <tbody>
        //                                                                 <tr>
        //                                                                     <td align='left'>
        //                                                                         <h4 style='margin: 0;font-size: 13px;font-weight: 600;
        //                                                                                                       line-height: 22px;
        //                                                                                                       font-family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;'>Đơn giá:</h4>
        //                                                                         <h3 style='color:#f60;font-size: 16px;
        //                                                                                                       line-height: 22px;margin: 0;font-weight: 600;
        //                                                                                                       font-family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;'>{{ $data['price'] }}</h3>
        //                                                                     </td>
        //                                                                     <td align='right'>
        //                                                                         <span style='font-size: 13px;
        //                                                                                                       line-height: 22px;
        //                                                                                                       font-family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;'>ứng viên / người</span>
        //                                                                     </td>
        //                                                                 </tr>
        //                                                             </tbody>
        //                                                         </table>
        //                                                     </td>
        //                                                 </tr>
        //                                             </tbody>
        //                                         </table>
        //                                     </td>
        //                                 </tr>
        //                             </tbody>
        //                         </table>
        //                     </td>
        //                 </tr>
        //             </tbody>
        //         </table>

        //     </td>
        // </tr>
        // ";
        // dd(Storage::disk('public')->exists(''));
        // $show_reviews = $comments->show_comments(1);

        // dd($show_reviews);

        // $body = '<div class='border border-secondary p-3' style='font-size: 1rem;color: black;'>
        //     <p><em>Hello ,</em></p>
        //     <p><em>
        //     We received a request to reset your account password for this email address. To begin the process of resetting your account's password, click on the code below.&nbsp;</em></p>
        //     <p><em>Code: </em></p>
        //     <p><em>Thank you !.<br>
        //     Shop Male Fashion;<br>
        //     </em></p></div>';

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
        // $date1 = '2022-08-11 04:03:00';
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




        // echo date('d-M-Y', strtotime($date)) . '\n';



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
