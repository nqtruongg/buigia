<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceivableRequest extends FormRequest
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

            // 'customer' => 'required',
            'ended_at' => 'required|date_format:d/m/Y',
            'contract_value' => 'required|max:255',
            'advance_date_1' => 'nullable|required_with:advance_value_1|date_format:d/m/Y',
            'advance_date_2' => 'nullable|required_with:advance_value_2|date_format:d/m/Y',
            'advance_date_3' => 'nullable|required_with:advance_value_3|date_format:d/m/Y',
            'advance_value_1' => 'nullable|required_with:advance_date_1|max:255',
            'advance_value_2' => 'nullable|required_with:advance_date_2|max:255',
            'advance_value_3' => 'nullable|required_with:advance_date_3|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $advance1 = str_replace(',', '', $this->input('advance_value_1', 0));
            $advance2 = str_replace(',', '', $this->input('advance_value_2', 0));
            $advance3 = str_replace(',', '', $this->input('advance_value_3', 0));
            $contractValue = str_replace(',', '', $this->input('contract_value', 0));

            $totalAdvances = (int)$advance1 + (int)$advance2 + (int)$advance3;

            if ($totalAdvances > $contractValue) {
                $validator->errors()->add('total_advance_hidden', 'Tổng tiền tạm ứng không được vượt quá giá trị hợp đồng.');
            }
        });
    }

    public function messages()
    {
        return [
            'customer.required' => 'Vui lòng nhập thông tin khách hàng.',
            'ended_at.required' => 'Vui lòng nhập ngày kết thúc.',
            'ended_at.date_format' => 'Ngày ký hợp đồng phải có định dạng dd/mm/yyyy.',
            'contract_value.required' => 'Vui lòng nhập giá trị hợp đồng.',
            'contract_value.max' => 'Giá trị hợp đồng không được vượt quá 255 ký tự.',
            'advance_date_1.required_with' => 'Vui lòng nhập ngày thanh toán tạm ứng 1.',
            'advance_date_1.date_format' => 'Ngày thanh toán tạm ứng 1 phải có định dạng dd/mm/yyyy.',
            'advance_value_1.required_with' => 'Vui lòng nhập giá trị tạm ứng 1.',
            'advance_value_1.max' => 'Giá trị tạm ứng 1 không được vượt quá 255 ký tự.',
            'advance_date_2.required_with' => 'Vui lòng nhập ngày thanh toán tạm ứng 2.',
            'advance_date_2.date_format' => 'Ngày thanh toán tạm ứng 2 phải có định dạng dd/mm/yyyy.',
            'advance_value_2.required_with' => 'Vui lòng nhập giá trị tạm ứng 2.',
            'advance_value_2.max' => 'Giá trị tạm ứng 2 không được vượt quá 255 ký tự.',
            'advance_date_3.required_with' => 'Vui lòng nhập ngày thanh toán tạm ứng 3.',
            'advance_date_3.date_format' => 'Ngày thanh toán tạm ứng 3 phải có định dạng dd/mm/yyyy.',
            'advance_value_3.required_with' => 'Vui lòng nhập giá trị tạm ứng 3.',
            'advance_value_3.max' => 'Giá trị tạm ứng 3 không được vượt quá 255 ký tự.',
        ];
    }
}
