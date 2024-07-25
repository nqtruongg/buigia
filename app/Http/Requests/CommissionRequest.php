<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommissionRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique('commissions')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
                'min_price' => ['required', 'numeric'],
                'max_price' => ['nullable', 'numeric'],
                'percent' => ['required', 'numeric'],
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'min_price.required' => 'Trường giá tối thiểu là bắt buộc.',
            'min_price.numeric' => 'Giá tối thiểu phải là một số.',

            'max_price.numeric' => 'Giá tối đa phải là một số.',

            'percent.required' => 'Trường phần trăm là bắt buộc.',
            'percent.numeric' => 'Phần trăm phải là một số.',
        ];
    }
}
