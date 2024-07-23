<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDialogRequest extends FormRequest
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
        $rules = [];

        if (isset($this->id_dialog)) {
            $rules['content_' . $this->id_dialog] = 'required';
        } else {
            $rules['content'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'content_' . $this->id_dialog . '.required' => 'Nội dung không được để trống.',
            'content.required' => 'Nội dung không được để trống.',
        ];
    }
}
