<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Category;
class UpdateProductRequest extends FormRequest
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
                'min:2',
                'max:255',
                Rule::unique('productions')->ignore($this->production),
            ],
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'descriptions' => [
                'required',
                'string',
                'min:2',
            ],
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
        ];
    }
}
