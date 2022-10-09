<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Comment::query();
        $this->table = (new Comment)->getTable();
    }

    public function index()
    {
        $comments = $this->model->leftJoin('customers', 'customers.id', '=', 'comments.customer_id')
            ->select('comments.*', 'customers.name as name')
            ->with('productions')
            ->get();
        foreach ($comments as $each) {
            if($each->parent_id !== null){
                $customer_id = Comment::where('id', '=', $each->parent_id)->first()->customer_id;
                $each['name_comment'] = Customer::find($customer_id)->name;
                $each['parent_slug'] = Comment::where('id', '=', $each->parent_id)->with('productions')->first()->productions['0']->slug;
            }
        }

        return view('backend.comments.index', [
            'comments' => $comments,
        ]);
    }

    public function action(Comment $comment, Request $request)
    {
        $comment->status = $request->action;
        $comment->save();
        return redirect()->back()->with('success', 'You evaluate the product successfully!!');
    }

    public function review_products(Request $request)
    {
        $arr = [];
        if ($request->customer_id !== null) {
            $arr['customer_id'] = $request->customer_id;
            $arr['parent_id'] = $request->parent_id ? $request->parent_id : null;
            $arr['content'] = $request->review_content;
            $arr['status'] = ACTIVE;
            $id = Comment::create($arr)->id;
        }
        $check = DB::table('production_comments')
            ->leftJoin('comments', 'comments.id', '=', 'production_comments.comment_id')
            ->where('production_comments.production_id', '=', $request->product_id)
            ->where('comments.customer_id', '=', $request->customer_id)->count();
        if ($check === 0) {
            $comments = Comment::find($id);
            $product_id = $request->product_id;
            $review = $request->ratings;
            $images = null;

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $path = Storage::disk('public')->put('imageReviews', $image);
                    $data[] = $path;
                }
                $images = json_encode($data);
            }
            $comments->productions()->attach(
                [
                    $product_id => ['review' => $review, 'images' => $images],
                ]
            );
        }
        return redirect()->back()->with('success', 'You evaluate the product successfully!!');
    }

    public function add_comments(Request $request)
    {
        $arr = [];
        if ($request->customer_id !== null) {
            $arr['customer_id'] = $request->customer_id;
            if ($request->comment_id !== null) {
                $arr['parent_id'] = $request->comment_id;
            } else {
                $arr['parent_id'] = null;
            }
            $arr['content'] = $request->content;
            $arr['status'] = NOT_ACTIVE;
            $id = Comment::create($arr)->id;
            if ($request->product_id !== null) {
                $comments = Comment::find($id);
                $product_id = $request->product_id;
                $comments->productions()->attach(
                    [
                        $product_id => ['review' => null, 'images' => null],
                    ]
                );
            }
        }
        return response('You successfully commented on the product!!', 200);
    }

    public function show_reviews($product_id)
    {
        // $comments = $this->model->with(['productions' => function ($query) use ($product_id) {
        //     $query->where('id', $product_id);
        // }])->get();
        $comments = DB::table('production_comments')
            ->leftJoin('comments', 'comments.id', '=', 'production_comments.comment_id')
            ->leftJoin('customers', 'customers.id', '=', 'comments.customer_id')
            ->select(
                'production_comments.review as review',
                'production_comments.images as images',
                'comments.id as id',
                'comments.customer_id as customer_id',
                'customers.name as name',
                'comments.content as content',
                'comments.status as action',
                'comments.created_at as created_at'
            )
            ->where('production_comments.production_id', '=', $product_id)
            ->whereNull('comments.parent_id')
            ->whereNotNull('production_comments.review')
            ->whereNull('production_comments.deleted_at')
            ->whereNull('comments.deleted_at')
            ->get();
        return $comments;
    }

    public function show_comments($product_id)
    {
        $comments = Comment::query()
            ->leftJoin('production_comments', 'comments.id', '=', 'production_comments.comment_id')
            ->leftJoin('customers', 'customers.id', '=', 'comments.customer_id')
            ->where('production_comments.production_id', $product_id)
            ->where('comments.status', '!=', CANCEL)
            ->select(
                'comments.*',
                'customers.name as name',
                'comments.created_at as created_at'
            )
            ->whereNull('production_comments.review')
            ->whereNull('production_comments.images')
            ->whereNull('production_comments.deleted_at')
            ->whereNull('production_comments.deleted_at')
            ->with(['parents' => function ($query) {
                $query->from('comments')->leftJoin('customers', 'customers.id', '=', 'comments.customer_id')
                    ->where('comments.status', '!=', CANCEL)
                    ->select('comments.*', 'customers.name');
            }])->get();
        return $comments;
    }
}
