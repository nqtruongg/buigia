<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
            'name' => ['required', 'max:255',
            Rule::unique('departments')->where(function ($query) {
                $query->whereNull('deleted_at')->whereNot('id', $this->id);
            }),
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => trans('language.department.title')]),
            'name.max' => trans('validation.max',['attribute' => 255]),
            'name.unique' => trans('validation.unique', ['attribute' => trans('language.department.title')]),
        ];
    }
}
