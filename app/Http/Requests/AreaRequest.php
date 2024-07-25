<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AreaRequest extends FormRequest
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
            'slug' => [
                'required',
                'max:255',
                'string',
                Rule::unique('areas')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
                'name' => ['required', 'string', 'max:255'],
                'city_id' => ['nullable', 'numeric'],
                'district_id' => ['required', 'numeric'],
                'commune_id' => ['required', 'numeric'],
                'parent_id' => ['nullable', 'numeric'],
                'address' => ['nullable', 'string', 'max:255'],
                'order' => ['nullable', 'numeric'],
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',
            'slug.required' => 'Trường slug là bắt buộc.',
            'slug.string' => 'Slug phải là một chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'city_id.numeric' => 'Thành phố phải là một số.',
            'district_id.required' => 'Quận huyện là bắt buộc.',
            'district_id.numeric' => 'Quận huyện phải là một số.',
            'commune_id.required' => 'Xã phường là bắt buộc.',
            'commune_id.numeric' => 'Xã phường phải là một số.',
            'parent_id.numeric' => 'Parent phải là một số.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
            'order.numeric' => 'Thứ tự phải là một số.',
        ];
    }
}
