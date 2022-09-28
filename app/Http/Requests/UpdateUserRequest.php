<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'fullname' => [
                'required',
            ],
            'address' => [
                'required',
                'string',
                'min:0',
                'max:255',
            ],
            'phone' => [
                'required',
            ],
            'photo_new' => [
                'nullable',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
            'birthday' => [
                'required',
            ],
            'gender' => [
                'required',
            ],
        ];
    }
}
