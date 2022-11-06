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
    public function __construct(Production $product, Category $category, Attribute $attribute, AttributeValue $attributeValue, ProductImage $productImage)
    {
        $this->product = $product;
        $this->category = $category;
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;
        $this->productImage = $productImage;
    }

    public function index()
    {
        $products = $this->product->leftJoin('product_images', 'productions.id', '=', 'product_images.production_id')
            ->get(['product_images.image as image', 'product_images.status as statusImage', 'productions.*']);

        $infos = DB::table('production_attr_value')
            ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
            ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
            ->leftJoin('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
            ->where('attributes.replace_id', '=', NameAttrEnum::SIZE)
            ->whereNull('production_attr_value.deleted_at')
            ->get();
        $groupSet = $infos->groupBy('product_id');

        $infoColor = DB::table('production_attr_value')
            ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
            ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
            ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
            ->where('attribute_values.attribute_id', '=', NameAttrEnum::COLOR)
            ->whereNull('production_attr_value.deleted_at')
            ->get();
        $groupColor = $infoColor->groupBy('product_id');

        foreach ($products as $each) {
            $each->status = $each->status_name;
            $each['infos'] = $groupSet[$each->id];
            $each['infoColor'] = $groupColor[$each->id];
            $each['size'] = NameAttrEnum::getKeys(NameAttrEnum::SIZE)[0];
            $each['color'] = NameAttrEnum::getKeys(NameAttrEnum::COLOR)[0];
        }


        return view('backend.productions.index', [
            'products' => $products,
        ]);
    }

    public function view(Production $production, CommentController $comments)
    {
        if (!empty($production)) {
            $product = $this->product->leftJoin('product_images', 'productions.id', '=', 'product_images.production_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->select('product_images.image as image', 'product_images.status as statusImage', 'discounts.discount_price as discountPrice', 'discounts.status as statusDiscount', 'productions.*')
                ->where('productions.slug', '=', $production->slug)->first();
            $infos = DB::table('production_attr_value')
                ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
                ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
                ->leftJoin('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
                ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
                ->where('attributes.replace_id', '=', NameAttrEnum::SIZE)
                ->where('production_attr_value.production_id', '=', $product->id)
                ->whereNull('production_attr_value.deleted_at')
                ->get();
            $infoColor = DB::table('production_attr_value')
                ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
                ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
                ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
                ->where('attribute_values.attribute_id', '=', NameAttrEnum::COLOR)
                ->where('production_attr_value.production_id', '=', $product->id)
                ->whereNull('production_attr_value.deleted_at')
                ->get();
            $product['infos'] = $infos;
            $product['infos2'] = $infoColor;

            foreach ($product['infos2'] as $each) {
                if (strtoupper($each->name) == ColorAttrEnum::getKey('c-1')) {
                    $each->class = ColorAttrEnum::BLACK;
                }
                if (strtoupper($each->name) == ColorAttrEnum::getKey('c-2')) {
                    $each->class = ColorAttrEnum::BLUE;
                }
                // if(strtoupper($each->name) == ColorAttrEnum::getKey('c-2')){
                //     $each->class = ColorAttrEnum::DELFT_BLUE;
                // }
                if (strtoupper($each->name) == ColorAttrEnum::getKey('c-3')) {
                    $each->class = ColorAttrEnum::PASTEL_ORANGE;
                }
                if (strtoupper($each->name) == ColorAttrEnum::getKey('c-4')) {
                    $each->class = ColorAttrEnum::RED;
                }
                if (strtoupper($each->name) == ColorAttrEnum::getKey('c-9')) {
                    $each->class = ColorAttrEnum::WHITE;
                }
            }

            if ($product->statusDiscount != 'active') {
                $product->discountPrice = 0;
            }

            $show_reviews = $comments->show_reviews($production->id);
            $show_comments = $comments->show_comments($production->id);

            $productRelated = $this->product->Join('product_images', 'productions.id', '=', 'product_images.production_id')
                ->leftJoin('categories', 'categories.id', '=', 'productions.category_id')
                ->leftJoin('discount_product', 'productions.id', '=', 'discount_product.production_id')
                ->leftJoin('discounts', 'discounts.id', '=', 'discount_product.discount_id')
                ->where('productions.status', '=', ACTIVE)
                ->where('categories.id', '=', $product->category_id)
                ->where('productions.id', '!=', $product->id)
                ->latest('productions.created_at')
                ->select(
                    'product_images.image as image',
                    'product_images.status as statusImage',
                    'categories.name as categoryName',
                    'discounts.discount_price as discountPrice',
                    'discounts.status as statusDiscount',
                    'productions.*'
                )->paginate(4);

            foreach ($productRelated as $each) {
                if ($each->statusDiscount == 'active') {
                    $each->discountPrice = (100 - $each->discountPrice) / 100;
                }
                $each['review'] = DB::table('production_comments')->where('production_id', '=', $each->id)->avg('review');
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

            $check_review =  DB::table('production_comments')
                ->leftJoin('comments', 'comments.id', '=', 'production_comments.comment_id')
                ->leftJoin('customers', 'customers.id', '=', 'comments.customer_id')
                ->select('comments.customer_id as customer_id', 'comments.id as id',)
                ->where('production_comments.production_id', '=', $product->id)->get();

            $check['customer_id'] = [];
            foreach ($check_review as $value) {
                $check['customer_id']["$value->id"] = $value->customer_id;
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
        }

        return view('frontend.errors.index');
    }

    public function create(Request $request)
    {
        $categories = $this->category->query()->get();
        $attrs = $this->attribute->query()
            ->with('attribute_values')
            ->with('replaces')
            ->whereNull('replace_id')
            ->get();
        foreach ($attrs as $value) {
            foreach ($value->replaces as $replaces) {
                if ($replaces->id == NameAttrEnum::SIZE_SET) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_SET)->get();
                }
                if ($replaces->id == NameAttrEnum::SIZE_SHOE) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_SHOE)->get();
                }
                if ($replaces->id == NameAttrEnum::SIZE_BAG) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_BAG)->get();
                }
            }
        }

        for ($i = 0; $i < count($attrs); $i++) {
            if (count($attrs["$i"]->attribute_values) > 0) {
                $attr[$i] = $attrs["$i"]->attribute_values;
            } else {
                $attr[$i] = $attrs["$i"]->replaces;
            }
        }
        $attrSize = $attr['0'] ? $attr['0'] : null;
        $attrColor = $attr['1'] ? $attr['1'] : null;

        return view('backend.productions.create', [
            'categories' => $categories,
            'attrSize' => $attrSize,
            'attrValueColor' => $attrColor,
        ]);
    }

    public function edit(Production $production)
    {
        $categories = $this->category->query()->get();

        $image = $this->productImage->query()->where('production_id', '=', $production->id)->whereNull('deleted_at')->get();
        $production['image'] = $image;

        $infos = DB::table('production_attr_value')
            ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
            ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
            ->leftJoin('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
            ->where('attributes.replace_id', '=', NameAttrEnum::SIZE)
            ->where('production_attr_value.production_id', '=', $production->id)
            ->whereNull('production_attr_value.deleted_at')
            ->get();


        $infoColor = DB::table('production_attr_value')
            ->leftJoin('productions', 'productions.id', '=', 'production_attr_value.production_id')
            ->leftJoin('attribute_values', 'attribute_values.id', '=', 'production_attr_value.attribute_value_id')
            ->select('production_attr_value.production_id as product_id', 'attribute_values.*')
            ->where('attribute_values.attribute_id', '=', NameAttrEnum::COLOR)
            ->where('production_attr_value.production_id', '=', $production->id)
            ->whereNull('production_attr_value.deleted_at')
            ->get();
        $production['infos'] = $infos;
        $production['infos2'] = $infoColor;

        $attrs = $this->attribute->query()
            ->with('attribute_values')
            ->with('replaces')
            ->whereNull('replace_id')
            ->get();
        foreach ($attrs as $value) {
            foreach ($value->replaces as $replaces) {
                if ($replaces->id == NameAttrEnum::SIZE_SET) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_SET)->get();
                }
                if ($replaces->id == NameAttrEnum::SIZE_SHOE) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_SHOE)->get();
                }
                if ($replaces->id == NameAttrEnum::SIZE_BAG) {
                    $replaces->replace_id = $this->attributeValue->where('attribute_id', '=', NameAttrEnum::SIZE_BAG)->get();
                }
            }
        }

        for ($i = 0; $i < count($attrs); $i++) {
            if (count($attrs["$i"]->attribute_values) > 0) {
                $attr[$i] = $attrs["$i"]->attribute_values;
            } else {
                $attr[$i] = $attrs["$i"]->replaces;
            }
        }
        $attrSize = $attr['0'] ? $attr['0'] : null;
        $attrColor = $attr['1'] ? $attr['1'] : null;

        return view('backend.productions.edit', [
            'each' => $production,
            'categories' => $categories,
            'attrSize' => $attrSize,
            'attrColor' => $attrColor,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $status = $request->input('status') ? '1' : '2';
        $slug = Str::slug($request->input('name'), '-');
        $arr = $request->validated();
        $arr['status'] = $status;
        $arr['slug'] = $slug;

        $arr2 = $request->validate([
            'fileData' => 'required',
            'status_image' => 'required',
            'attrValue1' => 'required',
            'attrValue' => 'required',
        ]);

        if ($request->hasFile('fileData')) {
            $images = $request->file('fileData');
            foreach ($images as $image) {
                $path = Storage::disk('public')->put('imageProducts', $image);
                $data[] = $path;
            }
        }
        $status_image = $request->input('status_image') ? '1' : '2';

        $id = $this->product->create($arr)->id;
        $arr2['image'] = json_encode($data);
        $arr2['status'] = $status_image;
        $arr2['production_id'] = $id;
        $this->productImage->query()->create($arr2);

        $arr3 = [];
        $attrValue1 = $request->input('attrValue1');
        foreach ($attrValue1 as $attrValue_id) {
            $arr3[] = [
                'production_id' => $id,
                'attribute_value_id' => $attrValue_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $attrValue_id = $request->input('attrValue');
        $arr3[] = [
            'production_id' => $id,
            'attribute_value_id' => $attrValue_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $insert = DB::table('production_attr_value')->insert($arr3);
        return redirect()->route('admin.productions')->with('addProductionStatus', 'Add successfully!!');
    }

    public function update(UpdateProductRequest $request, $productionId)
    {
        $production = $this->product->find($productionId);

        $status = $request->input('status') ? '1' : '2';
        $slug = Str::slug($request->input('name'), '-');
        $arr = $request->validated();

        $arr2 = $request->validate([
            'attrValue1' => 'required',
            'attrValue' => 'required',
        ]);

        $arr['status'] = $status;
        $arr['slug'] = $slug;

        $production->update($arr);
        DB::table('production_attr_value')->where('production_id', '=', $productionId)->delete();

        $arr2 = [];
        $attrValue1 = $request->input('attrValue1');
        foreach ($attrValue1 as $attrValue_id) {
            $arr2[] = [
                'production_id' => $productionId,
                'attribute_value_id' => $attrValue_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $attrValue_id = $request->input('attrValue');
        $arr2[] = [
            'production_id' => $productionId,
            'attribute_value_id' => $attrValue_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        DB::table('production_attr_value')->insert($arr2);
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
        $statusImage = $request->input('status_image') ? '1' : '2';
        $productImage->status = $statusImage;
        $productImage->image = $nameImage;

        if (is_numeric($productionId) && $productionId > 0) {
            $productImage->update();
            return redirect()->route("admin.productions")->with('EditProductionStatus', 'Edit successfully!!');
        } else {
            if (Storage::disk('public')->exists($nameImage)) {
                Storage::disk('public')->delete($nameImage);
            }
            return redirect()->route('admin.productions')->with('ProductionErrors', 'Edit Failed Production table');
        }
    }

    public function destroy($productionId)
    {
        $production = $this->product->find($productionId);
        $production->product_images()->delete();
        $production->delete();
        DB::table('production_attr_value')
            ->where('production_id', $productionId)
            ->update([
                'updated_at' => Carbon::now(),
                'deleted_at' => Carbon::now(),
            ]);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
