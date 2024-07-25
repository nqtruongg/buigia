<?php

namespace App\Http\Requests;

use App\Models\CategoryPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(CategoryPost::class, 'slug')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                })
            ],
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'description_seo' => 'nullable|string|max:255',
            'keyword_seo' => 'nullable|string|max:255',
            'title_seo' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'language' => 'nullable|string|max:50',
            'active' => 'nullable|boolean',
            'hot' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable',
        ];
    }

    /**
     * Lấy các thông báo lỗi áp dụng cho yêu cầu này.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Trường tên phải là một chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'slug.string' => 'Trường slug phải là một chuỗi.',
            'slug.max' => 'Trường slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã được sử dụng.',
            'image_path.image' => 'Đường dẫn hình ảnh phải là một hình ảnh.',
            'image_path.mimes' => 'Đường dẫn hình ảnh phải là một tệp có định dạng: jpeg, png, jpg, gif.',
            'image_path.max' => 'Đường dẫn hình ảnh không được vượt quá 2048 kilobytes.',
            'banner_path.image' => 'Đường dẫn banner phải là một hình ảnh.',
            'banner_path.mimes' => 'Đường dẫn banner phải là một tệp có định dạng: jpeg, png, jpg, gif.',
            'banner_path.max' => 'Đường dẫn banner không được vượt quá 2048 kilobytes.',
            'description.string' => 'Trường mô tả phải là một chuỗi.',
            'description_seo.string' => 'Trường mô tả SEO phải là một chuỗi.',
            'description_seo.max' => 'Trường mô tả SEO không được vượt quá 255 ký tự.',
            'keyword_seo.string' => 'Trường từ khóa SEO phải là một chuỗi.',
            'keyword_seo.max' => 'Trường từ khóa SEO không được vượt quá 255 ký tự.',
            'title_seo.string' => 'Trường tiêu đề SEO phải là một chuỗi.',
            'title_seo.max' => 'Trường tiêu đề SEO không được vượt quá 255 ký tự.',
            'content.string' => 'Trường nội dung phải là một chuỗi.',
            'language.string' => 'Trường ngôn ngữ phải là một chuỗi.',
            'language.max' => 'Trường ngôn ngữ không được vượt quá 50 ký tự.',
            'active.boolean' => 'Trường hoạt động phải là true hoặc false.',
            'hot.boolean' => 'Trường hot phải là true hoặc false.',
            'order.integer' => 'Trường thứ tự phải là một số nguyên.',
            'parent_id.exists' => 'Mã danh mục cha không hợp lệ.',
        ];
    }
}
