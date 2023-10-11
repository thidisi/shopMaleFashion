<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
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
            'userName' => 'required|string|min:4|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ];
    }

    public function messages()
    {
        return [
            'userName.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'userName.unique' => 'Tên người dùng đã tồn tại',
            'email.unique' => 'Email này đã tồn tại',
            'userName.min' => 'Tối thiểu 4 kí tự',
            'userName.max' => 'Giới hạn 20 kí tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.regex' => 'Tối thiểu 6 ký tự, ít nhất 1 chữ cái viết hoa, 1 kí tự đặc biệt, 1 chữ cái viết thường và 1 chữ số',
        ];
    }
}
