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
    public function __construct(Comment $comment, Customer $customer)
    {
        $this->comment = $comment;
        $this->customer = $customer;
    }

    public function index()
    {
        $comments = $this->comment->with(['customers', 'productions'])
            ->latest("created_at")
            ->get();
        foreach ($comments as $each) {
            if ($each->parent_id !== null) {
                $each['product'] = $comments->find($each->parent_id)->productions['0'];
            }
        }

        return view('backend.comments.index', [
            'comments' => $comments,
        ]);
    }

    public function feedback(Request $request)
    {
        $arr = [];
        $arr['customer_id'] = 7;
        $arr['parent_id'] = $request->commentId;
        $arr['content'] = $request->content;
        $arr['status'] = 'pending';
        // $this->comment->create($arr);
        return response('You successfully feedback on the customer!!', 200);
    }

    public function action(Comment $comment, Request $request)
    {
        $comment->status = $request->action;
        $comment->save();
        return redirect()->back()->with('success', 'You evaluate the product successfully!!');
    }

    public function review_products(Request $request)
    {
        $check = $this->comment->with('productions')
            ->whereHas('productions', function ($query) use ($request) {
                $query->whereId($request->product_id);
                $query->whereNotNull('review');
            })->where('customer_id', $request->customer_id)->count();
        if ($check === 0) {
            $arr = [];
            if ($request->customer_id !== null) {
                $arr['customer_id'] = $request->customer_id;
                $arr['parent_id'] = $request->parent_id ? $request->parent_id : null;
                $arr['content'] = $request->review_content;
                $arr['status'] = 'active';
                $id = $this->comment->create($arr)->id;
            }
            $comments = $this->comment->find($id);
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
            return redirect()->back()->with('success', 'You evaluate the product successfully!!');
        }
        return redirect()->back()->with('error', 'You evaluate the product error!!');
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
            $arr['status'] = 'pending';
            $id = $this->comment->create($arr)->id;
            if ($request->product_id !== null) {
                $comments = $this->comment->find($id);
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
        $reviews = $this->comment->with(['productions', 'customers'])
            ->whereHas('productions', function ($query) use ($product_id) {
                $query->whereId($product_id);
                $query->whereNotNull('review');
            })->whereNull(['deleted_at', 'parent_id'])->get();

        $reviews->map(function ($query) {
            $query->review = $query->productions->first()->pivot->review;
            if(!empty($query->productions->first()->pivot->images)){
                $query->images = json_decode($query->productions->first()->pivot->images)['0'];
            }
            $query->name = $query->customers->name;
            return $query;
        });
        return $reviews;
    }

    public function show_comments($product_id, $customer_id = null)
    {
        $comments = $this->comment->with(['productions', 'customers', 'children'])
            ->whereHas('productions', function ($query) use ($product_id) {
                $query->whereId($product_id);
                $query->whereNull(['images', 'review']);
            })
            ->whereNull(['deleted_at', 'parent_id'])->where('status', '!=', 'inactive')->get();
        $comments->map(function ($query) {
            $query->name = $query->customers->name;
            if (!empty($query->children)) {
                $query->children->map(function ($queryTwo) {
                    $queryTwo->name = $this->customer->find($queryTwo->customer_id)->name;
                    return $queryTwo;
                });
            }
            return $query;
        });
        $comments->each(function ($comment, $key) use (&$comments, $customer_id) {
            if ($comment->status === 'pending') {
                if ($comment->customer_id != $customer_id) {
                    $comments->forget($key);
                }
            }
            if (!empty($comment->children)) {
                $children = $comment->children;
                $children->each(function ($parent, $key_parent) use (&$children, $customer_id) {
                    if ($parent->status === 'pending') {
                        if ($parent->customer_id != $customer_id) {
                            $children->forget($key_parent);
                        }
                    }
                });
            }
        });
        return $comments;
    }
}
