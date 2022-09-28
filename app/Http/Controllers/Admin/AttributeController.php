<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\StoreAttrValueRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Requests\UpdateAttrValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    private object $model;

    public function __construct()
    {
        $this->model = Attribute::query();
        $this->table = (new Attribute)->getTable();
    }

    public function index()
    {
        $attr = $this->model->get();
        $attrValue = Attribute::Join('attribute_values', 'attribute_values.attribute_id', '=', 'attributes.id')
            ->select(['attributes.name as attr_name', 'attribute_values.*'])
            ->whereNull('attribute_values.deleted_at')
            ->get();
        foreach ($attr as $each) {
            $each->status = $each->status_name;
        }
        foreach ($attrValue as $value) {
            $value->status = $value->status_name;
        }
        return view('backend.attributes.index', [
            'attr' => $attr,
            'attrValue' => $attrValue,
        ]);
    }

    public function create()
    {
        $replace = $this->model->whereNull('replace_id')->get();
        return view('backend.attributes.create',[
            'replace' => $replace,
        ]);
    }

    public function createValue()
    {
        $attr = $this->model->whereNull('replace_id')
            ->with('replaces')
            ->get();
        return view('backend.attributes.createValue', [
            'attr' => $attr,
        ]);
    }

    public function store(StoreAttributeRequest $request)
    {
        $status = $request->input('status') ? '1' : '2';
        $arr = $request->validated();
        $arr['status'] = $status;
        $this->model->create($arr);
        // $id = $this->model->create($arr)->id;
 
        return redirect()->route('admin.attributes')->with('addAttrStatus', 'Add successfully!!');
    }

    public function storeValue(StoreAttrValueRequest $request)
    {
        $status = $request->input('status') ? '1' : '2';
        $arr = $request->validated();
        $arr['status'] = $status;
        AttributeValue::query()->create($arr);

        return redirect()->route('admin.attributes')->with('addAttrStatus', 'Add successfully!!');
    }

    public function edit(Attribute $attribute)
    {
        $replace = $this->model->whereNull('replace_id')->get();
        return view('backend.attributes.edit', [
            'each' => $attribute,
            'replace' => $replace,
        ]);
    }

    public function editValue(AttributeValue $attributeValue)
    {
        $attr = $this->model->whereNull('replace_id')
            ->with('replaces')
            ->get();
        return view('backend.attributes.editValue', [
            'each' => $attributeValue,
            'attr' => $attr,
        ]);
    }

    public function update(UpdateAttributeRequest $request, $attributeId)
    {
        $attribute = $this->model->find($attributeId);
        $attribute->name = $request->input('name');
        $attribute->slug = $request->input('slug');
        $attribute->descriptions = $request->input('descriptions');
        $attribute->replace_id = $request->input('replace_id');
        $attribute->status = $request->input('status') ? '1' : '2';
        $attribute->update();
        return redirect()->route('admin.attributes')->with('EditAttrStatus', 'Edit successfully!!');
    }

    public function updateValue(UpdateAttrValueRequest $request, $attrValueId)
    {
        $attrValue = AttributeValue::find($attrValueId);
        $attrValue->name = $request->input('name');
        $attrValue->slug = $request->input('slug');
        $attrValue->descriptions = $request->input('descriptions');
        $attrValue->attribute_id = $request->input('attribute_id');
        $attrValue->status = $request->input('status') ? '1' : '2';
        $attrValue->update();
        return redirect()->route('admin.attributes')->with('EditAttrStatus', 'Edit successfully!!');
    }

    // public function destroy($attributeId)
    // {
    //     $attribute = Attribute::find($attributeId);
    //     $attribute->attribute_values()->delete();
    //     $attribute->delete();
    //     return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    // }

    public function destroyValue($attributeValueId)
    {
        AttributeValue::destroy($attributeValueId);
        return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
    }
}
