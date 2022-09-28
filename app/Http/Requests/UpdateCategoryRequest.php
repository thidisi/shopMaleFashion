<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Major_Category;


class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('categories')->ignore($this->category),
            ],
            'slug' => [
                'required',
                'string',
                'min:2',
                'max:500',
            ],
            'photo_new' => [
                'nullable',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
            'major_category_id' => [
                'required',
                Rule::exists(Major_Category::class, 'id'),
            ],
        ];
    }
}
