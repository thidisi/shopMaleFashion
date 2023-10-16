<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\About;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Major_Category;
use App\Models\Production;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function __construct(Major_Category $major_category, Discount $discount, AttributeValue $attributeValue, Production $product, Category $category)
    {
        $this->major_category = $major_category;
        $this->discount = $discount;
        $this->product = $product;
        $this->category = $category;
        $this->attributeValue = $attributeValue;
    }

    public function index()
    {
        $majorCategories = $this->major_category->latest('created_at')->paginate(5);
        return view('backend.menu.index', [
            'majorCategories' => $majorCategories,
        ]);
    }

    public function view(Major_Category $menu)
    {
        try {
            $majorCategories = $this->major_category->whereStatus('show')->get('slug');
            foreach ($majorCategories as $each) {
                $data[] = $each->slug;
            }
            $breadCrumb = Major_Category::where('slug', '=', $menu->slug)->first();

            if (in_array($menu->slug, $data)) {
                $menu_id = $this->major_category->where('slug', '=', $menu->slug)->first()->id;

                $products = $this->product->with(['categories', 'product_images', 'discount_products'])
                    ->whereHas('categories', function ($query) use ($menu_id) {
                        $query->where('major_category_id', $menu_id);
                    })
                    ->where('status', Production::PRODUCTION_STATUS['ACTIVE'])
                    ->latest('created_at')->paginate(16);
            }

            if ($menu->slug == PROMOTION) {
                $products = $this->product->with(['categories', 'product_images', 'discount_products'])
                    ->whereHas('discount_products', function ($query) {
                        $query->whereNotNull('discount_id');
                    })
                    ->where('status', Production::PRODUCTION_STATUS['ACTIVE'])
                    ->latest('created_at')->paginate(16);
            }

            if ($menu->slug == NEW_PRODUCTS) {
                $date_end = Carbon::now()->addDays(-7);

                $products = $this->product->with(['categories', 'product_images', 'discount_products'])
                    ->where('status', Production::PRODUCTION_STATUS['ACTIVE'])
                    ->where('created_at', '>=', $date_end)
                    ->latest('created_at')->paginate(16);
            }

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

            $categories = $this->category->with('productions')->whereStatus(Category::CATEGORY_STATUS['ACTIVE'])->get();
            $categories->map(function ($query) {
                $query->count = $query->productions->count();
                return $query;
            });

            $filter_price_list = [
                '0-49000' => '0' . ' - ' . currency_format(49000),
                '49000-99000' => currency_format(49000) . ' - ' . currency_format(99000),
                '99000-199000' => currency_format(99000) . ' - ' . currency_format(199000),
                '199000-299000' => currency_format(199000) . ' - ' . currency_format(299000),
                '299000-399000' => currency_format(299000) . ' - ' . currency_format(399000),
                '399000-599000' => currency_format(399000) . ' - ' . currency_format(599000),
                '599000+' => currency_format(599000) . ' +',
            ];

            $filter_color_list = $this->attributeValue->with('attributes')
                ->whereHas('attributes', function ($query) {
                    $query->whereNull('replace_id');
                })->whereStatus('active')->get();

            return view('frontend.shops.index', [
                'categories' => $categories,
                'products' => $products,
                'breadCrumb' => $breadCrumb,
                'filter_price_list' => $filter_price_list,
                'filter_color_list' => $filter_color_list,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }

    public function create()
    {
        $status = Major_Category::MENU_STATUS;
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
        $arr['slug'] = Str::slug($request->input('name'), '-');
        $this->major_category->create($arr);

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
        try {
            $majorCategory = $this->major_category->findOrFail($majorCategoryId);
            $arr = $request->validate([
                'name' => [
                    'required',
                    'unique:major_categories,name,' . $majorCategoryId
                ],
                'status' => 'required',
            ]);
            $arr['slug'] = Str::slug($request->input('name'), '-');
            $majorCategory->update($arr);
            return redirect()->route('admin.major-categories')->with('EditMajorCategoryStatus', 'Edit successfully!!');
        } catch (\Throwable $th) {
            return redirect()->route('errors');
        }
    }
}
