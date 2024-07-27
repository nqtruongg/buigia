<?php

namespace App\Http\Requests;

use App\Models\FilterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterTypeRequest extends FormRequest
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
        // $status = $this->input('status');

        $rules = [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique(FilterType::class, 'name')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên đã tồn tại.',
        ];
    }
}
