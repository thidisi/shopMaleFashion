<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\About;
use App\Models\Category;
use App\Models\Major_Category;
use App\Models\Production;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Major_Category::query();
        $this->table = (new Major_Category)->getTable();
    }

    public function index()
    {
        $majorCategories = $this->model->latest()->paginate(5);
        foreach ($majorCategories as $each) {
            $each->status = $each->status_name;
        }
        return view('backend.menu.index', [
            'majorCategories' => $majorCategories,
        ]);
    }

    public function view(Major_Category $menu)
    {
        $majorCategories = $this->model->where('status', '=', MenuStatusEnum::SHOW)->get('slug');
        foreach ($majorCategories as $each) {
            $data[] = $each->slug;
        }
        if (in_array($menu->slug, $data)) {
            $menuId = $this->model->where('slug', '=', $menu->slug)->first()->id;

            $breadCrumb = $this->model->find($menuId);

            $products = Production::Join('product_images', 'productions.id', '=', 'product_images.production_id')
                ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->where('categories.major_category_id', '=', "$menuId")
                ->where('productions.status', '=', ACTIVE)
                ->latest('productions.created_at')
                ->select(
                    'product_images.image as image',
                    'product_images.status as statusImage',
                    'categories.name as categoryName',
                    'discounts.discount_price as discountPrice',
                    'discounts.status as statusDiscount',
                    'productions.*'
                )->paginate(12);
            $categories = Category::leftJoin('productions', 'categories.id', '=', 'productions.category_id')
                ->where('categories.major_category_id', '=', "$menuId")
                ->selectRaw('categories.id, categories.name, count(productions.category_id) AS `count`',)
                ->groupBy('categories.name')
                ->orderBy('count', 'DESC')
                ->get();
            foreach ($products as $each) {
                $each->image = json_decode($each->image)[0];
                if ($each->statusDiscount == 'active') {
                    $each->discountPrice = (100 - $each->discountPrice) / 100;
                }
                $each['review'] = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
            }
        }

        if ($menu->slug == PROMOTION) {
            $breadCrumb = Major_Category::where('slug', '=', $menu->slug)->first();

            $products = Production::Join('product_images', 'productions.id', '=', 'product_images.production_id')
                ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->whereNotNull('discounts.discount_price')
                ->where('discounts.status', 'active')
                ->where('productions.status', '=', ACTIVE)
                ->latest('productions.created_at')
                ->select(
                    'product_images.image as image',
                    'product_images.status as statusImage',
                    'categories.name as categoryName',
                    'discounts.discount_price as discountPrice',
                    'discounts.status as statusDiscount',
                    'productions.*'
                )->paginate(12);
            foreach ($products as $each) {
                $id[] = $each->id;
            }
            $categories = Category::leftJoin('productions', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->selectRaw('categories.id, categories.name, count(productions.category_id) AS `count`',)
                ->where('discounts.status', 'active')
                ->groupBy('categories.name')
                ->orderBy('count', 'DESC')
                ->get();
            foreach ($products as $each) {
                $each->image = json_decode($each->image)[0];
                $each->discountPrice = (100 - $each->discountPrice) / 100;
                $each['review'] = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
            }
        }

        if ($menu->slug == NEW_PRODUCTS) {
            $breadCrumb = Major_Category::where('slug', '=', $menu->slug)->first();

            $date_end = Carbon::now()->addDays(-7);

            $products = Production::Join('product_images', 'productions.id', '=', 'product_images.production_id')
                ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->where('productions.created_at', '>=', $date_end)
                ->where('productions.status', ACTIVE)
                ->latest('productions.created_at')
                ->select(
                    'product_images.image as image',
                    'product_images.status as statusImage',
                    'categories.name as categoryName',
                    'discounts.discount_price as discountPrice',
                    'discount_product.status as statusDiscount',
                    'productions.*'
                )->paginate(12);

            $categories = Category::leftJoin('productions', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->selectRaw('categories.id, categories.name, count(productions.category_id) AS `count`',)
                ->where('productions.created_at', '>=', $date_end)
                ->groupBy('categories.name')
                ->orderBy('count', 'DESC')
                ->get();
            foreach ($products as $each) {
                $each->image = json_decode($each->image)[0];
                $each->discountPrice = (100 - $each->discountPrice) / 100;
                $each['review'] = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
            }
        }

        if (!empty($products)) {
            return view('frontend.shops.index', [
                'categories' => $categories,
                'products' => $products,
                'breadCrumb' => $breadCrumb->name,
            ]);
            exit;
        }
        return view('frontend.errors.index');
    }

    public function create()
    {
        $status = MenuStatusEnum::getKeys();
        return view('backend.menu.create', [
            'status' => $status,
        ]);
    }

    public function store(Request $request)
    {
        $arr = $request->validate([
            'name' => "required|unique:major_categories|min:2|max:255",
            'status' => 'required',
        ]);
        $arr['created_at'] = now();
        $this->model->create($arr);

        return redirect()->route('admin.major-categories')->with('addMajorCategoryStatus', 'Add successfully!!');
    }

    public function edit(Major_Category $majorCategory)
    {
        $status = MenuStatusEnum::getKeys();
        return view('backend.menu.edit', [
            'each' => $majorCategory,
            'status' => $status,
        ]);
    }

    public function update(Request $request, $majorCategoryId)
    {
        $majorCategory = $this->model->find($majorCategoryId);
        $arr = $request->validate([
            'name' => [
                'required',
                'unique:major_categories,name,' . $majorCategoryId
            ],
            'status' => 'required',
        ]);
        $majorCategory->update($arr);
        return redirect()->route('admin.major-categories')->with('EditMajorCategoryStatus', 'Edit successfully!!');
    }
}
