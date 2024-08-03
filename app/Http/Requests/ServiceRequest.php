<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Rules\Alpha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
                Rule::unique(Service::class, 'name')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
            'slug' => [
                'required',
                'max:255',
                Rule::unique(Service::class, 'slug')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                }),
            ],
            'price' => 'required|string|max:255',
//            'description' => 'required|string|max:500',
            // 'percent' => 'required',
            'acreage' => 'required',
            'type' => 'required',
            'houseHolder' => 'required',
            'category_id' => 'required',
            'direction' => ['string', new Alpha],
            'city_id' => 'required',
            'district_id' => 'required',
            'commune_id' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ là bắt buộc.',
            'name.max' => 'Tên dịch vụ không thể vượt quá :max ký tự.',
            'name.unique' => 'Tên dịch vụ đã tồn tại.',

            'slug.required' => 'Vui lòng nhập slug.',
            'slug.max' => 'Slug không thể vượt quá :max ký tự.',
            'slug.unique' => 'Slug này đã tồn tại.',

            'price.required' => 'Giá là bắt buộc.',
            'price.string' => 'Giá phải là một chuỗi.',
            'price.max' => 'Giá không thể vượt quá :max ký tự.',

            'direction.string' => 'Hướng phải là chữ',
            'city_id.required' => 'Vui lòng chọn thành phố',
            'district_id.required' => 'Vui lòng chọn quận',
            'commune_id.required' => 'Vui lòng chọn xã',
            'address.required' => 'Vui lòng nhập địa chỉ',

//            'description.required' => 'Mô tả là bắt buộc.',
//            'description.string' => 'Mô tả phải là một chuỗi.',
//            'description.max' => 'Mô tả không thể vượt quá :max ký tự.',
            // 'percent.required' => 'Phần trăm hoa hồng là bắt buộc',
            'type.required' => 'Tình trạng là bắt buộc',
            'acreage.required' => 'Diện tích là bắt buộc',
            'houseHolder.required' => 'Vui lòng chọn chủ nhà',
            'category_id.required' => 'Bạn cần chọn danh mục bất động sản'
        ];
    }
}
