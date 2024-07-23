<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDialogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        // Lấy tất cả các trường dữ liệu từ request
        $requestData = $this->all();

        // Lặp qua mỗi trường dữ liệu
        foreach ($requestData as $key => $value) {
            // Kiểm tra xem trường dữ liệu có phải là content_{{$id}} hay không
            if (strpos($key, 'content_') === 0) {
                // Trường dữ liệu có tên động, thêm quy tắc xác thực cho nó
                $rules[$key] = 'required|string|max:255'; // Thêm các quy tắc của bạn ở đây
            }
        }

        return $rules;

        
    }
}
