<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $status = $this->input('status');
        $type = $this->input('type');
        $rules = [
            'type' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'tax_code' => 'nullable|string|max:255',
            'status' => 'required',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique(Customer::class, 'email')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
            'phone' => [
                'required',
                'digits_between:10,11',
                'numeric',
                Rule::unique(Customer::class, 'phone')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
            'address' => 'nullable|string|max:255',
            'invoice_address' => 'nullable|string|max:255',
            'career' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ];

        if ($status == 1 || $status == 2) {
            $rules += [
                'services' => 'required',
                'services.*' => 'required',
                'start' => 'required',
                'start.*' => 'required',
                'end' => 'required',
                'end.*' => 'required',
                'view_total' => 'required',
                'view_total.*' => 'required',
                'note' => 'nullable|array|max:100',
                'note.*' => 'nullable|string|max:100',
                'supplier' => 'nullable|array|max:100',
                'supplier.*' => 'nullable|string|max:100',
            ];
        }

        if($type == 1){
            $rules += [
                'responsible_person' => 'required|string|max:255',

            ];
        }else{
            $rules += [
                'responsible_person' => 'nullable|string|max:255',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'responsible_person.required' => 'Trường người chịu trách nhiệm là bắt buộc.',
            'responsible_person.string' => 'Người chịu trách nhiệm phải là một chuỗi ký tự.',
            'responsible_person.max' => 'Người chịu trách nhiệm không được vượt quá :max ký tự.',

            'tax_code.string' => 'Mã số thuế phải là một chuỗi ký tự.',
            'tax_code.max' => 'Mã số thuế không được vượt quá :max ký tự.',

            'status.required' => 'Trường trạng thái là bắt buộc.',

            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.unique' => 'Email đã tồn tại.',

            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.digits_between' => 'Số điện thoại phải có độ dài từ :min đến :max chữ số.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',

            'invoice_address.required' => 'Trường địa chỉ hóa đơn là bắt buộc.',
            'invoice_address.string' => 'Địa chỉ hóa đơn phải là một chuỗi ký tự.',
            'invoice_address.max' => 'Địa chỉ hóa đơn không được vượt quá :max ký tự.',



            'career.string' => 'Ngành nghề phải là một chuỗi ký tự.',
            'career.max' => 'Ngành nghề không được vượt quá :max ký tự.',

            'services' => 'Trường dịch vụ là bắt buộc',
            'services.*' => 'Trường dịch vụ là bắt buộc',
            'time.required' => 'Trường thời gian là bắt buộc.',
            'time.*.required' => 'Trường thời gian là bắt buộc.',
            'start.required' => 'Trường thời gian bắt đầu là bắt buộc.',
            'start.*.required' => 'Trường thời gian bắt đầu là bắt buộc.',
            'end.required' => 'Trường thời gian kết thúc là bắt buộc.',
            'end.*.required' => 'Trường thời gian kết thúc là bắt buộc.',
            'view_total.required' => 'Trường thành tiền là bắt buộc.',
            'view_total.*.required' => 'Trường thành tiền là bắt buộc.',
            'note.nullable' => 'Trường ghi chú có thể là null.',
            'note.*.nullable' => 'Trường ghi chú có thể là null.',
            'note.string' => 'Ghi chú phải là một chuỗi ký tự.',
            'note.*.string' => 'Ghi chú phải là một chuỗi ký tự.',
            'note.max' => 'Ghi chú không được vượt quá :max ký tự.',
            'note.*.max' => 'Ghi chú không được vượt quá :max ký tự.',

            'supplier.nullable' => 'Nhà cung cấp có thể là null.',
            'supplier.*.nullable' => 'Nhà cung cấp có thể là null.',
            'supplier.string' => 'Nhà cung cấp là một chuỗi ký tự.',
            'supplier.*.string' => 'Nhà cung cấp phải là một chuỗi ký tự.',
            'supplier.max' => 'Nhà cung cấp không được vượt quá :max ký tự.',
            'supplier.*.max' => 'Nhà cung cấp không được vượt quá :max ký tự.',
            'user_id.required' => 'Nhân viên tư vấn là bắt buộc.',
            'user_id.exists' => 'Người dùng không tồn tại.',
        ];
    }
}
