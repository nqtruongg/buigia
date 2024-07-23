<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceivableRequest extends FormRequest
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
            'contract_value' => 'nullable|array',
            'contract_value.*' => 'nullable|max:255',
            'advance_date_1' => 'nullable|array',
            'advance_date_1.*' => 'nullable|required_with:advance_value_1.*|date_format:d/m/Y',
            'advance_value_1' => 'nullable|array',
            'advance_value_1.*' => 'nullable|required_with:advance_date_1.*|max:255',
            'advance_date_2' => 'nullable|array',
            'advance_date_2.*' => 'nullable|required_with:advance_value_2.*|date_format:d/m/Y',
            'advance_value_2' => 'nullable|array',
            'advance_value_2.*' => 'nullable|required_with:advance_date_2.*|max:255',
            'advance_date_3' => 'nullable|array',
            'advance_date_3.*' => 'nullable|required_with:advance_value_3.*|date_format:d/m/Y',
            'advance_value_3' => 'nullable|array',
            'advance_value_3.*' => 'nullable|required_with:advance_date_3.*|max:255',

            'reason_1' => 'nullable|array',
            'reason_2' => 'nullable|array',
            'reason_3' => 'nullable|array',
            'reason_1.*' => 'nullable|required_with:advance_value_1.*',
            'reason_2.*' => 'nullable|required_with:advance_value_2.*',
            'reason_3.*' => 'nullable|required_with:advance_value_3.*',
        ];
    }



    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            $advance1Values = $this->input('advance_value_1', []);
            $advance2Values = $this->input('advance_value_2', []);
            $advance3Values = $this->input('advance_value_3', []);
            $contractValues = $this->input('contract_value', []);

            foreach ($contractValues as $key => $contractValue) {
                $advance1Value = (int) str_replace(',', '', $advance1Values[$key] ?? 0);
                $advance2Value = (int) str_replace(',', '', $advance2Values[$key] ?? 0);
                $advance3Value = (int) str_replace(',', '', $advance3Values[$key] ?? 0);

                $totalAdvance = (int)$advance1Value + (int)$advance2Value + (int)$advance3Value;
                if ($totalAdvance > str_replace(',', '', $contractValue)) {
                    $validator->errors()->add('total_advance_hidden.' . $key, 'Tổng tiền tạm ứng không được vượt quá giá trị hợp đồng.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'customer.required' => 'Vui lòng nhập tên khách hàng.',
            'contract_value.required' => 'Vui lòng nhập giá trị hợp đồng.',
            'contract_value.*.required' => 'Vui lòng nhập giá trị hợp đồng.',
            'contract_value.*.max' => 'Giá trị hợp đồng không được vượt quá 255 ký tự.',
            'advance_date_1.*.required_with' => 'Vui lòng nhập ngày nếu giá trị tiền được cung cấp.',
            'advance_date_1.*.date_format' => 'Vui lòng nhập định dạng ngày hợp lệ (dd/mm/yyyy).',
            'advance_value_1.*.required_with' => 'Vui lòng nhập giá trị tiền nếu ngày được cung cấp.',
            'advance_value_1.*.max' => 'Giá trị tiền không được vượt quá 255 ký tự.',
            'advance_date_2.*.required_with' => 'Vui lòng nhập ngày nếu giá trị tiền được cung cấp.',
            'advance_date_2.*.date_format' => 'Vui lòng nhập định dạng ngày hợp lệ (dd/mm/yyyy).',
            'advance_value_2.*.required_with' => 'Vui lòng nhập giá trị tiền nếu ngày được cung cấp.',
            'advance_value_2.*.max' => 'Giá trị tiền không được vượt quá 255 ký tự.',
            'advance_date_3.*.required_with' => 'Vui lòng nhập ngày nếu giá trị tiền được cung cấp.',
            'advance_date_3.*.date_format' => 'Vui lòng nhập định dạng ngày hợp lệ (dd/mm/yyyy).',
            'advance_value_3.*.required_with' => 'Vui lòng nhập giá trị tiền nếu ngày được cung cấp.',
            'advance_value_3.*.max' => 'Giá trị tiền không được vượt quá 255 ký tự.',

            'reason_1.*.required_with' => 'Vui lòng nhập lý do.',
            'reason_2.*.required_with' => 'Vui lòng nhập lý do.',
            'reason_3.*.required_with' => 'Vui lòng nhập lý do.',
        ];
    }
}
