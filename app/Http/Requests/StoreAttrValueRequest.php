<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttrValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'unique:attribute_values,name',
            ],
            'slug' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'descriptions' => [
                'nullable',
                'string',
                'min:2',
                'max:500',
            ],
            'attribute_id' => [
                'required',
                Rule::exists(Attribute::class, 'id')
            ],
        ];
    }
}
