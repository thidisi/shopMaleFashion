<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'photo_new' => [
                'nullable',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ],
            'email' => [
                'required',
                'email',
            ],
            'phone' => [
                'required',
                'string',
            ],
            'phone_second' => [
                'nullable',
                'string',
            ],
            'address' => [
                'required',
                'string',
            ],
            'address_second' => [
                'nullable',
                'string',
            ],
            'branch' => [
                'required',
                'string',
            ],
            'branch_second' => [
                'nullable',
                'string',
            ],
            'link_address_fb' => [
                'nullable',
                'string',
            ],
            'link_address_youtube' => [
                'nullable',
                'string',
            ],
            'link_address_zalo' => [
                'nullable',
                'string',
            ],
            'link_address_instagram' => [
                'nullable',
                'string',
            ],
        ];
    }
}
