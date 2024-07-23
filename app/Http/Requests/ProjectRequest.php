<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'customer_id' => 'required',
            'type' => 'required',
            'status' => 'required',
            'received_date' => 'nullable|date_format:d/m/Y',
            'reply_date' => 'nullable|date_format:d/m/Y',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            '*.date_format' => "Vui lòng nhập đúng định dạng Ngày/Tháng/Năm",
            '*.numeric' => "Vui lòng nhập đúng định dạng số",
            'name.required' => 'Tên dự án không được để trống',
            'name.max' => 'Vui lòng không nhập quá 255 ký tự',
            'customer_id.required' => 'Vui lòng chọn khách hàng',
            'type.required' => 'Vui lòng chọn dạng dự án',
            'status.required' => 'Vui lòng chọn trạng thái',
        ];
    }
}
