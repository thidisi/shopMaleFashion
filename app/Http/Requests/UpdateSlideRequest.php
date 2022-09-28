<?php

namespace App\Http\Requests;

use App\Enums\SortOrderSlideEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Major_Category;

class UpdateSlideRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
            ],
            'fileDataNew' => [
                'nullable',
            ],
            'major_category_id' => [
                'required',
                Rule::exists(Major_Category::class, 'id'),
            ],
            'sort_order' => [
                'required',
                Rule::in(SortOrderSlideEnum::asArray()),
            ],
        ];
    }
}
