<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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

class CategoryController extends Controller
{
    public function __construct(Category $category, Production $product, Major_Category $major_category, Discount $discount, AttributeValue $attributeValue)
    {
        $this->category = $category;
        $this->product = $product;
        $this->major_category = $major_category;
        $this->discount = $discount;
        $this->attributeValue = $attributeValue;
    }

    public function index()
    {
        $categories = $this->category->with('major_categories')->latest('created_at')->get();
        return view('backend.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function view()
    {
        $products = $this->product->with(['categories', 'product_images', 'discount_products'])
            ->where('status', Production::PRODUCTION_STATUS['ACTIVE'])
            ->latest('created_at')->paginate(16);

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
            '599000' => currency_format(599000) . ' +',
        ];

        $filter_color_list = $this->attributeValue->with('attributes')
            ->whereHas('attributes', function ($query) {
                $query->whereNull('replace_id');
            })->whereStatus('active')->get();

        return view('frontend.shops.index', [
            'categories' => $categories,
            'products' => $products,
            'filter_price_list' => $filter_price_list,
            'filter_color_list' => $filter_color_list,
        ]);
    }

    public function create()
    {
        $majorCategories = $this->major_category->where('status', '!=', Major_Category::MENU_STATUS['HOT_DEFAULT'])->get();
        return view('backend.categories.create', [
            'major_categories' => $majorCategories
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $path = '';
        if ($request->file('avatar')) {
            $path = Storage::disk('public')->put('avatarCategories', $request->file('avatar'));
        }
        $status = $request->input('status') ? Category::CATEGORY_STATUS['ACTIVE'] : Category::CATEGORY_STATUS['INACTIVE'];
        $arr = $request->validated();
        $arr['avatar'] = $path;
        $arr['status'] = $status;
        $this->category->create($arr);

        return redirect()->route('admin.categories')->with('addCategoryStatus', 'Add successfully!!');
    }

    public function edit(Category $category)
    {
        $majorCategories = $this->major_category->where('status', '!=', Major_Category::MENU_STATUS['HOT_DEFAULT'])->get();
        return view('backend.categories.edit', [
            'each' => $category,
            'major_categories' => $majorCategories
        ]);
    }

    public function update(UpdateCategoryRequest $request, $categoryId)
    {
        try {
            $category = $this->category->findOrFail($categoryId);
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->status = $request->input('status') ? Category::CATEGORY_STATUS['ACTIVE'] : Category::CATEGORY_STATUS['INACTIVE'];
            $category->major_category_id = $request->input('major_category_id');

            $nameAvatar = null;
            if ($request->hasFile('photo_new')) {
                if ($request->file('photo_new')->isValid()) {
                    $nameAvatar = Storage::disk('public')->put('avatarCategories', $request->file('photo_new'));
                }
            }
            if ($nameAvatar == '') {
                $nameAvatar = $request->input('photo_old');
            }
            $category->avatar = $nameAvatar;
            if (is_numeric($categoryId) && $categoryId > 0) {
                $category->update();
                return redirect()->route("admin.categories")->with('EditCategoryStatus', 'Edit successfully!!');
            } else {
                if (Storage::disk('public')->exists($nameAvatar)) {
                    Storage::disk('public')->delete($nameAvatar);
                }
                return redirect()->route('admin.categories')->with('CategoryErrors', 'Edit Failed Category table');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Sửa không thành công!!');
        }
    }

    public function destroy($categoryId)
    {
        $this->category->destroy($categoryId);
        return response('Category deleted successfully.', 200);
    }
}
