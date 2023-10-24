<?php

namespace App\Http\Requests;

use App\Models\Production;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountProductRequest extends FormRequest
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
            'production_id' => [
                'required',
                'unique:discount_product,production_id',
                Rule::exists(Production::class, 'id'),
            ],
            'discount_id' => 'required|exists:discounts,id',
        ];
    }
}
