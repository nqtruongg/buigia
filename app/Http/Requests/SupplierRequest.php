<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'responsible_person' => 'required|string|max:255',
            'tax_code' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique(Supplier::class, 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
            'phone' => [
                'required',
                'digits_between:10,11',
                'numeric',
                Rule::unique(Supplier::class, 'phone')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'responsible_person.required' => 'Trường người đại diện là bắt buộc.',
            'responsible_person.string' => 'Người đại diện phải là một chuỗi ký tự.',
            'responsible_person.max' => 'Người đại diện không được vượt quá :max ký tự.',

            'tax_code.string' => 'Mã số thuế phải là một chuỗi ký tự.',
            'tax_code.max' => 'Mã số thuế không được vượt quá :max ký tự.',



            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.unique' => 'Email đã tồn tại.',

            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.digits_between' => 'Số điện thoại phải có độ dài từ :min đến :max chữ số.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',






        ];
    }
}
