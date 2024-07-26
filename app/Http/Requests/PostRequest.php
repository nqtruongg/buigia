<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(Post::class, 'slug')->where(function ($query) {
                    $query->whereNull('deleted_at')->whereNot('id', $this->id);
                })
            ],
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'banner_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
            'description_seo' => 'nullable|string|max:255',
            'keyword_seo' => 'nullable|string|max:255',
            'title_seo' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:50',
            'active' => 'nullable|boolean',
            'hot' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'category_id' => 'required|exists:App\Models\CategoryPost,id',
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'required' => 'Vui lòng nhập tên.',
                'string' => 'Tên phải là một chuỗi.',
                'max' => 'Tên không được vượt quá 255 ký tự.',
            ],
            'slug' => [
                'nullable' => 'Slug là một trường tùy chọn.',
                'string' => 'Slug phải là một chuỗi.',
                'max' => 'Slug không được vượt quá 255 ký tự.',
                'unique' => 'Slug đã tồn tại.',
            ],
            'image_path' => [
                'nullable' => 'Ảnh là một trường tùy chọn.',
                'image' => 'Ảnh phải là một tệp hình ảnh.',
                'mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            ],
            'banner_path' => [
                'nullable' => 'Banner là một trường tùy chọn.',
                'image' => 'Banner phải là một tệp hình ảnh.',
                'mimes' => 'Banner phải có định dạng jpeg, png, jpg hoặc gif.',
            ],
            'description' => [
                'nullable' => 'Mô tả là một trường tùy chọn.',
                'string' => 'Mô tả phải là một chuỗi.',
            ],
            'description_seo' => [
                'nullable' => 'Mô tả SEO là một trường tùy chọn.',
                'string' => 'Mô tả SEO phải là một chuỗi.',
                'max' => 'Mô tả SEO không được vượt quá 255 ký tự.',
            ],
            'keyword_seo' => [
                'nullable' => 'Từ khóa SEO là một trường tùy chọn.',
                'string' => 'Từ khóa SEO phải là một chuỗi.',
                'max' => 'Từ khóa SEO không được vượt quá 255 ký tự.',
            ],
            'title_seo' => [
                'nullable' => 'Tiêu đề SEO là một trường tùy chọn.',
                'string' => 'Tiêu đề SEO phải là một chuỗi.',
                'max' => 'Tiêu đề SEO không được vượt quá 255 ký tự.',
            ],
            'language' => [
                'nullable' => 'Ngôn ngữ là một trường tùy chọn.',
                'string' => 'Ngôn ngữ phải là một chuỗi.',
                'max' => 'Ngôn ngữ không được vượt quá 50 ký tự.',
            ],
            'active' => [
                'nullable' => 'Trạng thái hoạt động là một trường tùy chọn.',
                'boolean' => 'Trạng thái hoạt động phải là một giá trị boolean.',
            ],
            'hot' => [
                'nullable' => 'Hot là một trường tùy chọn.',
                'boolean' => 'Hot phải là một giá trị boolean.',
            ],
            'order' => [
                'nullable' => 'Thứ tự là một trường tùy chọn.',
                'integer' => 'Thứ tự phải là một số nguyên.',
            ],
            'category_id' => [
                'required' => 'Vui lòng chọn danh mục.',
                'exists' => 'Danh mục không tồn tại.',
            ],
        ];
    }
}
