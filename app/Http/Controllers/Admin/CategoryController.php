<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\About;
use App\Models\Category;
use App\Models\Major_Category;
use App\Models\Production;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct(Category $category, Production $production, Major_Category $major_category)
    {
        $this->category = $category;
        $this->production = $production;
        $this->major_category = $major_category;
    }

    public function index()
    {
        $categories = $this->catogory->leftJoin('major_categories', 'categories.major_category_id', '=', 'major_categories.id')
            ->latest('categories.created_at')
            ->get(['major_categories.name as name_majorCate', 'categories.*']);
        foreach ($categories as $each) {
            $each->status = $each->status_name;
        }
        return view('backend.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function view()
    {
        $products = $this->production->Join('product_images', 'productions.id', '=', 'product_images.production_id')
            ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
            ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
            ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
            ->where('productions.status', '=', ACTIVE)
            ->latest('productions.created_at')
            ->select(
                'product_images.image as image',
                'product_images.status as statusImage',
                'categories.name as categoryName',
                'discounts.discount_price as discountPrice',
                'discounts.status as statusDiscount',
                'productions.*'
            )->paginate(8);

        $categories = $this->catogory->leftJoin('productions', 'categories.id', '=', 'productions.category_id')
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


        return view('frontend.shops.index', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function create()
    {
        $majorCategories = $this->major_category->where('status', '!=', MenuStatusEnum::HOT_DEFAULT)->get();
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
        $status = $request->input('status') ? '1' : '2';
        $arr = $request->validated();
        $arr['avatar'] = $path;
        $arr['status'] = $status;
        $this->category->create($arr);

        return redirect()->route('admin.categories')->with('addCategoryStatus', 'Add successfully!!');
    }

    public function edit(Category $category)
    {
        $majorCategories = $this->major_category->where('status', '!=', MenuStatusEnum::HOT_DEFAULT)->get();
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
            $category->status = $request->input('status') ? '1' : '2';
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
