<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique(User::class, 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                })
            ],
            'phone' => ['required', 'digits_between:10,11', 'numeric', Rule::unique(User::class, 'phone')->where(function ($query) {
                $query->whereNull('deleted_at')->whereNot('id', $this->id);
            })],
            'department_id' => 'required',
            'role_id' => 'required',
            'address' => 'nullable|string',
        ];

        $id = $this->route('id');

        if (!$id) {
            $rules['password'] = 'required|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Vui lòng nhập tên.',
            'last_name.required' => 'Vui lòng nhập họ.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 10 đến 11 chữ số.',
            'department_id.required' => 'Vui lòng chọn phòng ban.',
            'role_id.required' => 'Vui lòng chọn vai trò.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là một chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ];
    }
}
