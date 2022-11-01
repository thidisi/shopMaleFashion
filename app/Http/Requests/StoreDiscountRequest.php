<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest
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
            'date_start' => [
                'required',
                'date',
            ],
            'date_end' => [
                'required',
                'date',
                'after:date_start',
            ],
            'discount_price' => [
                'required',
                'unique:discounts,discount_price'
            ],
        ];
    }
}
