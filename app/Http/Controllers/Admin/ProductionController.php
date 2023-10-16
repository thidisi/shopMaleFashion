<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ColorAttrEnum;
use App\Enums\MenuStatusEnum;
use App\Enums\NameAttrEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\District;
use App\Models\Major_Category;
use App\Models\ProductImage;
use App\Models\Production;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ProductionController extends Controller
{
    /**
     * Construct
     */
    public function __construct(Production $product, Category $category, Attribute $attribute, AttributeValue $attributeValue, ProductImage $productImage, Discount $discount, Customer $customer, Comment $comment, Major_Category $major_category)
    {
        $this->product = $product;
        $this->category = $category;
        $this->major_category = $major_category;
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;
        $this->productImage = $productImage;
        $this->discount = $discount;
        $this->customer = $customer;
        $this->comment = $comment;
    }

    public function index()
    {
        $products = $this->product->with(['product_images', 'attribute_values'])->get();
        $products = $products->map(function ($query) {
            $query->infoAttr = $query->attribute_values->groupBy('attribute_id');
            return $query;
        });
        $attrs = $this->attribute->get(['id', 'name']);

        return view('backend.productions.index', [
            'products' => $products,
            'attrs' => $attrs,
        ]);
    }

    public function view($product_slug, CommentController $comments)
    {
        try {
            $product = $this->product->with(['attribute_values', 'product_images', 'discount_products'])
                ->whereStatus(Production::PRODUCTION_STATUS['ACTIVE'])
                ->whereSlug($product_slug)->firstOrFail();
            $product->image = $product->product_images->image;
            $product->discount = 1;
            $product->discountStatus = Discount::DISCOUNT_STATUS['CLOSE'];
            if ($product->discount_products) {
                $product->discount = (100 - $this->discount->find($product->discount_products->discount_id)->discount_price) / 100;
                $product->discountStatus = Discount::DISCOUNT_STATUS['ACTIVE'];
            }
            $attrValues = $product->attribute_values->groupBy('attribute_id');
            $product->infosColor = $attrValues->min();
            $product->infosSize = $attrValues->max();

            $show_reviews = $comments->show_reviews($product->id);
            $show_comments = $comments->show_comments($product->id, session('sessionIdCustomer'));

            $productRelated = $this->product->with(['categories', 'product_images', 'discount_products'])
                ->where('id', '!=', $product->id)
                ->whereCategoryId($product->category_id)
                ->whereStatus(Production::PRODUCTION_STATUS['ACTIVE'])
                ->latest('created_at')->paginate(4);

            foreach ($productRelated as $each) {
                $each->image = json_decode($each->product_images->image)[0];
                $each->discount = 1;
                $each->discountStatus = Discount::DISCOUNT_STATUS['CLOSE'];
                if (!empty($each->discount_products)) {
                    $each->discount = (100 - $this->discount->find($each->discount_products->discount_id)->discount_price) / 100;
                    $each->discountStatus = Discount::DISCOUNT_STATUS['ACTIVE'];
                }
                $each->review = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
            }

            $rating = DB::table('production_comments')->where('production_id', '=', $product->id)->whereNotNull('review')->avg('review');
            $count_review = DB::table('production_comments')->where('production_id', '=', $product->id)->whereNotNull('review')->count('production_id');
            $data_reviews = DB::table('production_comments')->selectRaw('review, count(production_id) as count_reviews')->where('production_id', '=', $product->id)->whereNotNull('review')->groupBy('review')->get();

            $reviews = [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
            ];

            foreach ($data_reviews as $each) {
                $reviews["$each->review"] = $each->count_reviews;
            }

            $rating_avg = round($rating);

            $rating = $rating ? number_format($rating, 1) : 0;

            $check_review = Comment::query()->with('productions')
                ->whereHas('productions', function ($query) use ($product) {
                    $query->whereId($product->id);
                    $query->whereNotNull('review');
                })
                ->get();
            $check['customer_id'] = [];
            foreach ($check_review as $key => $value) {
                $check['customer_id']["$key"] = $value->customer_id;
            }
            return view('frontend.product_detail.index', [
                'each' => $product,
                'productRelated' => $productRelated,
                'rating' => $rating,
                'rating_avg' => $rating_avg,
                'count_review' => $count_review,
                'reviews' => $reviews,
                'show_reviews' => $show_reviews,
                'show_comments' => $show_comments,
                'check_review' => $check,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function filter_list(Request $request)
    {
        // if($request->ajax()){
        $products = $this->product->with(['categories', 'product_images', 'discount_products', 'attribute_values'])
            ->where('status', Production::PRODUCTION_STATUS['ACTIVE']);
        if (!empty($request->menu_slug)) {
            $menu_id = $this->major_category->where('status', '!=', 'hide')->whereSlug($request->menu_slug)->first()->id;
            if (!empty($menu_id)) {
                $majorCategories = $this->major_category->whereStatus('show')->get('slug');
                foreach ($majorCategories as $each) {
                    $data[] = $each->slug;
                }

                if (in_array($request->menu_slug, $data)) {
                    $products->whereHas('categories', function ($query) use ($menu_id) {
                        $query->where('major_category_id', $menu_id);
                    });
                }
                if ($request->menu_slug == PROMOTION) {
                    $products->whereHas('discount_products', function ($query) {
                        $query->whereNotNull('discount_id');
                    });
                }
                if ($request->menu_slug == NEW_PRODUCTS) {
                    $date_end = Carbon::now()->addDays(-7);
                    $products->where('created_at', '>=', $date_end);
                }
            }
        }
        if (!empty($request->categories)) {
            $products->whereIn('category_id', $request->categories);
        }
        if (!empty($request->price)) {
            foreach ($request->price as $each) {
                $price[] = explode('-', $each);
            }
            $price = array_unique(array_reduce($price, 'array_merge', array()));
            $min_price = min($price);
            $max_price = max($price);
            $key_max_value = array_search('599000+', $price);
            if ($key_max_value === 0) {
                $products->where('price', '>=', '599000');
            }
            if ($key_max_value) {
                $max_price = $price[$key_max_value - 1];
                $products->where('price', '>=', '599000')->orwhereBetween('price', [$min_price, $max_price]);
            } else {
                $products->whereBetween('price', [$min_price, $max_price]);
            }
        }
        if (!empty($request->size)) {
            $products->whereHas('attribute_values', function ($query) use ($request) {
                $query->whereIn('id', $request->size);
            });
        }
        if (!empty($request->color)) {
            $products->whereHas('attribute_values', function ($query) use ($request) {
                $query->whereIn('slug', $request->color);
            });
        }
        if (!empty($request->order_by)) {
            if ($request->order_by == 'DESC') {
                $products->latest('price');
            } else {
                $products->oldest('price');
            }
        } else {
            $products->latest('created_at');
        }

        $products = $products->paginate(12);
        foreach ($products as $each) {
            $each->image = json_decode($each->product_images->image)[0];
            $each->discount = 1;
            $each->discountStatus = Discount::DISCOUNT_STATUS['CLOSE'];
            if (!empty($each->discount_products)) {
                $each->discount = (100 - $this->discount->find($each->discount_products->discount_id)->discount_price) / 100;
                $each->discountStatus = Discount::DISCOUNT_STATUS['ACTIVE'];
            }
            $each->review = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
        }

        return response()->json([
            'products' => $products,
            'url' => config('app.url'),
        ], 200);
        // }
    }

    public function create(Request $request)
    {
        $categories = $this->category->get();
        $attrs = $this->attribute
            ->with(['attribute_values'])
            ->get(['id', 'name', 'replace_id']);
        $attrs = $attrs->map(function ($query) {
            if (!empty($query->attribute_values)) {
                $query->infoAttr = $query->attribute_values->groupBy('attribute_id');
                $query->infoAttr = $query->infoAttr->first();
            }
            return $query;
        });
        return view('backend.productions.create', [
            'categories' => $categories,
            'attrs' => $attrs,
        ]);
    }

    public function edit($product)
    {
        $production = $this->product->with(['product_images', 'attribute_values', 'categories'])->findOrFail($product);
        $categories = $this->category->get();
        $attrs = $this->attribute
            ->with(['attribute_values'])
            ->get(['id', 'name', 'replace_id']);
        $attrs = $attrs->map(function ($query) {
            if (!empty($query->attribute_values)) {
                $query->infoAttr = $query->attribute_values->groupBy('attribute_id');
                $query->infoAttr = $query->infoAttr->first();
            }
            return $query;
        });
        $attrValues = $production->attribute_values->groupBy('attribute_id');
        foreach ($attrValues as $key => $each) {
            if ($this->attribute->find($key)->replace_id != null) {
                $attrKey['size'] = $this->attribute->find($key);
            }
        }
        $attrKey['color'] = $attrValues->min()->first();
        $attrValue = $attrValues->max();

        return view('backend.productions.edit', [
            'each' => $production,
            'categories' => $categories,
            'attrs' => $attrs,
            'attrKey' => $attrKey,
            'attrValue' => $attrValue,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $status = $request->input('status') ? Production::PRODUCTION_STATUS['ACTIVE'] : Production::PRODUCTION_STATUS['INACTIVE'];
            $slug = Str::slug($request->input('name'), '-');
            $arr = $request->validated();
            $arr['status'] = $status;
            $arr['slug'] = $slug;
            $arr2 = $request->validate([
                'fileData' => 'required',
                'status_image' => 'required',
                'attrValues' => 'required',
                'attrValue' => 'required',
            ]);
            if ($request->hasFile('fileData')) {
                $images = $request->file('fileData');
                foreach ($images as $image) {
                    $path = Storage::disk('public')->put('imageProducts', $image);
                    $data[] = $path;
                }
            }
            $status_image = $request->input('status_image') ? ProductImage::PRODUCT_IMAGE_STATUS['ACTIVE'] : ProductImage::PRODUCT_IMAGE_STATUS['INACTIVE'];
            $id = $this->product->create($arr)->id;
            $arr2['image'] = json_encode($data);
            $arr2['status'] = $status_image;
            $arr2['production_id'] = $id;
            $this->productImage->create($arr2);
            $product = $this->product->find($id);
            $arr3 = $request->input('attrValues');
            $arr3[] = $request->input('attrValue');
            $product->attribute_values()->sync($arr3);
            return redirect()->route('admin.productions')->with('addProductionStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function update(UpdateProductRequest $request, $productionId)
    {
        try {
            $production = $this->product->findOrFail($productionId);
            $status = $request->input('status') ? Production::PRODUCTION_STATUS['ACTIVE'] : Production::PRODUCTION_STATUS['INACTIVE'];
            $slug = Str::slug($request->input('name'), '-');
            $arr = $request->validated();
            $arr2 = $request->validate([
                'attrValues' => 'required',
                'attrValue' => 'required',
            ]);
            $arr['status'] = $status;
            $arr['slug'] = $slug;
            $production->update($arr);
            $arr2 = $request->input('attrValues');
            $arr2[] = $request->input('attrValue');
            $production->attribute_values()->sync($arr2);
            $nameImage = null;
            if ($request->hasFile('fileDataNew')) {
                if ($request->file('fileDataNew')) {
                    $images = $request->file('fileDataNew');
                    foreach ($images as $image) {
                        $path = Storage::disk('public')->put('imageProducts', $image);
                        $nameImage[] = $path;
                    }
                }
            }
            if ($nameImage == '') {
                $nameImage = $request->input('fileDataOld');
            }
            $productImage = $this->productImage->firstWhere('production_id', $productionId);
            $statusImage = $request->input('status_image') ? ProductImage::PRODUCT_IMAGE_STATUS['ACTIVE'] : ProductImage::PRODUCT_IMAGE_STATUS['INACTIVE'];
            $productImage->status = $statusImage;
            $productImage->image = $nameImage;

            if (is_numeric($productionId) && $productionId > 0) {
                $productImage->save();
                return redirect()->route("admin.productions")->with('EditProductionStatus', 'Edit successfully!!');
            } else {
                if (Storage::disk('public')->exists($nameImage)) {
                    Storage::disk('public')->delete($nameImage);
                }
                return redirect()->route('admin.productions')->with('ProductionErrors', 'Edit Failed Production table');
            }
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function destroy($productionId)
    {
        try {
            $production = $this->product->findOrFail($productionId);
            $production->product_images()->delete();
            $production->delete();
            DB::table('production_attr_value')
                ->where('production_id', $productionId)
                ->update([
                    'updated_at' => Carbon::now(),
                    'deleted_at' => Carbon::now(),
                ]);
            return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }
}
