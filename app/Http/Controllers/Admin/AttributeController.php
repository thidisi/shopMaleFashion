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
    public function __construct(Attribute $attribute, AttributeValue $attributeValue)
    {
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;
    }

    public function index()
    {
        $attr = $this->attribute->latest('created_at')->get();
        $attrValue = $this->attributeValue->with('attributes')->latest('created_at')->get();
        // dd($attr);
        return view('backend.attributes.index', [
            'attr' => $attr,
            'attrValue' => $attrValue,
        ]);
    }

    public function create()
    {
        $replace = $this->attribute->whereNull('replace_id')->get();
        return view('backend.attributes.create', [
            'replace' => $replace,
        ]);
    }

    public function createValue()
    {
        $attr = $this->attribute->whereNull('replace_id')
            ->with('replaces')
            ->get();
        return view('backend.attributes.createValue', [
            'attr' => $attr,
        ]);
    }

    public function store(StoreAttributeRequest $request)
    {
        try {
            $status = $request->input('status') ? Attribute::ATTRIBUTE_STATUS['ACTIVE'] : Attribute::ATTRIBUTE_STATUS['INACTIVE'];
            $arr = $request->validated();
            $arr['status'] = $status;
            $this->attribute->create($arr);
            return redirect()->route('admin.attributes')->with('addAttrStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('AddAttrStatusErr', 'Add not error!!');
        }
    }

    public function storeValue(StoreAttrValueRequest $request)
    {
        try {
            $status = $request->input('status') ? AttributeValue::ATTRIBUTE_VALUE_STATUS['ACTIVE'] : AttributeValue::ATTRIBUTE_VALUE_STATUS['INACTIVE'];
            $arr = $request->validated();
            $arr['status'] = $status;
            $this->attributeValue->create($arr);
            return redirect()->route('admin.attributes')->with('addAttrStatus', 'Add successfully!!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('AddAttrStatusErr', 'Add not error!!');
        }
    }

    public function edit(Attribute $attribute)
    {
        $replace = $this->attribute->whereNull('replace_id')->get();
        return view('backend.attributes.edit', [
            'each' => $attribute,
            'replace' => $replace,
        ]);
    }

    public function editValue(AttributeValue $attributeValue)
    {
        $attr = $this->attribute->whereNull('replace_id')
            ->with('replaces')
            ->get();
        return view('backend.attributes.editValue', [
            'each' => $attributeValue,
            'attr' => $attr,
        ]);
    }

    public function update(UpdateAttributeRequest $request, $attributeId)
    {
        try {
            $attribute = $this->attribute->findOrFail($attributeId);
            $attribute->name = $request->input('name');
            $attribute->slug = $request->input('slug');
            $attribute->descriptions = $request->input('descriptions');
            $attribute->replace_id = $request->input('replace_id');
            $attribute->status = $request->input('status') ? '1' : '2';
            $attribute->save();
            return redirect()->route('admin.attributes')->with('EditAttrStatus', 'Edit successfully!!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Edit not error!!');
        }
    }

    public function updateValue(UpdateAttrValueRequest $request, $attrValueId)
    {
        try {
            $attrValue = $this->attributeValue->findOrFail($attrValueId);
            $attrValue->name = $request->input('name');
            $attrValue->slug = $request->input('slug');
            $attrValue->descriptions = $request->input('descriptions');
            $attrValue->attribute_id = $request->input('attribute_id');
            $attrValue->status = $request->input('status') ? '1' : '2';
            $attrValue->save();
            return redirect()->route('admin.attributes')->with('EditAttrStatus', 'Edit successfully!!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Edit not error!!');
        }
    }

    public function destroyValue($attributeValueId)
    {
        try {
            $this->attributeValue->destroy($attributeValueId);
            return redirect()->back()->with('deleteSuccess', 'Xóa thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('EditAttrStatusErr', 'Sửa không thành công!!');
        }
    }
}
