<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Attribute;

class UpdateAttrValueRequest extends FormRequest
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
                Rule::unique('attribute_values')->ignore($this->attributeValue),
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
                Rule::exists(Attribute::class, 'id'),
            ]
        ];
    }
}
