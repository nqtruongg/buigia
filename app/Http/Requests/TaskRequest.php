<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => 'required| max:255',
            'project_id' => 'required',
            'type' => 'required',
            'description' => 'nullable| max:500',
            'estimate_time' => 'nullable|numeric',
            'percent' => 'nullable|numeric|digits_between:1,10',
            'started_date' => 'nullable|date_format:d/m/Y',
            'ended_date' => 'nullable|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tiêu đề',
            'type.required' => 'Vui lòng chọn loại công việc',
            'name.max' => 'Vui lòng nhập nhiều nhất 255 ký tự',
            'project_id.required' => 'Vui lòng chọn dự án',
            '*.numeric' => 'Vui lòng nhập định dạng là số',
            '*.date_format' => "Vui lòng nhập đúng định dạng Ngày/Tháng/Năm",
            'percent.gt' => 'Vui lòng nhập giá trị lớn hơn 0'
        ];
    }
}
