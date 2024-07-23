<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceQuoteRequest extends FormRequest
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
            'customer' => 'required',
            'content' => 'required',
            'name' => 'required|string|max:255',
            'services' => 'required',
            'services.*' => 'required',
            'note' => 'nullable|array|max:100',
            'note.*' => 'nullable|string|max:100',
            'view_total' => 'required|max:255',
            'view_total.*' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'customer.required' => 'Khách hàng là bắt buộc.',
            'content.required' => 'Nội dung là bắt buộc.',
            'name.required' => 'Tên báo giá là bắt buộc.',
            'name.string' => 'Tên báo giá phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'services.required' => 'Dịch vụ là bắt buộc.',
            'services.*.required' => 'Dịch vụ là bắt buộc.',
            'note.array' => 'Ghi chú phải là một mảng.',
            'note.max' => 'Ghi chú không thể có nhiều hơn 100 phần tử.',
            'note.*.string' => 'Ghi chú phải là một chuỗi ký tự.',
            'note.*.max' => 'Ghi chú không được vượt quá 100 ký tự.',
            'view_total.required' => 'Số tiền là bắt buộc.',
            'view_total.max' => 'Số tiền không được vượt quá 255 ký tự.',
            'view_total.*.required' => 'Số tiền là bắt buộc.',
            'view_total.*.max' => 'Số tiền không được vượt quá 255 ký tự.',
        ];
    }
}
