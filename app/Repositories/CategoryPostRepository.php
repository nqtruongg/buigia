<?php

namespace App\Repositories;

use App\Models\CategoryPost;
use App\Models\PostCate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryPostRepository
{

    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListCategoryPost()
    {
        $categoryPost = CategoryPost::select(
            'id',
            'name',
            'slug',
            'hot',
            'active',
            'order',
            'parent_id',
            'description',
            'content',
        )
            ->where('parent_id', 0)
            ->orderBy('id', 'DESC')
            ->paginate(self::PAGINATE);
        return $categoryPost;
    }

    public function getCategoryPostByIdCate($id)
    {
        $categoryPost = CategoryPost::where('parent_id', $id)
            ->paginate(self::PAGINATE);
        return $categoryPost;
    }

    public function getCategoryPostById($id)
    {
        $categoryPost = CategoryPost::find($id);
        return $categoryPost;
    }

    public function createCategoryPost($request)
    {

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/categoryPosts');
            $request->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/categoryPosts');
            $request->banner_path = Storage::url($path);
        }

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'image_path' => $request->image_path,
            'banner_path' => $request->banner_path,
            'description' => $request->description,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
            'title_seo' => $request->title_seo,
            'content' => $request->content,
            'language' => 'vi',
            'active' => $request->active,
            'hot' => $request->hot,
            'order' => $request->order,
            'parent_id' => $request->parent_id ?? 0,
            'user_id' => Auth::user()->id
        ];

        CategoryPost::create($data);

        return true;
    }

    public function updateCategoryPost($request, $id)
    {
        $categoryPost = CategoryPost::findOrFail($id);

        if(!$categoryPost) {
            return false;
        }

        if ($request->hasFile('image_path')) {
            if ($categoryPost->image_path) {
                $imagePath = 'public/categoryPosts/' . basename($categoryPost->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/categoryPosts');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $categoryPost->image_path;
        }

        if ($request->hasFile('banner_path')) {
            if ($categoryPost->banner_path) {
                $bannerPath = 'public/categoryPosts/' . basename($categoryPost->banner_path);
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            $path = $request->file('banner_path')->store('public/categoryPosts');
            $bannerPath = Storage::url($path);
        } else {
            $bannerPath = $categoryPost->image_path;
        }

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'image_path' => $imagePath,
            'banner_path' => $bannerPath,
            'description' => $request->description,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
            'title_seo' => $request->title_seo,
            'content' => $request->content,
            'language' => 'vi',
            'active' => $request->active,
            'hot' => $request->hot,
            'order' => $request->order,
            'parent_id' => $request->parent_id ?? 0,
            'user_id' => Auth::user()->id
        ];

        $categoryPost->update($data);

        return true;
    }

    public function deleteCategoryPost($id)
    {
        $categoryPost = CategoryPost::find($id);

        if(!$categoryPost) {
            return false;
        }

        foreach ($categoryPost->childs as $child) {
            $this->deleteCategoryPost($child->id);
        }

        if ($categoryPost->image_path) {
            $imagePath = 'public/categoryPosts/' . basename($categoryPost->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($categoryPost->banner_path) {
            $bannerPath = 'public/categoryPosts/' . basename($categoryPost->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $categoryPost->delete();
        return true;
    }
}
