<?php

namespace App\Repositories;

use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\PostCate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListPost($request)
    {
        $post = Post::query();
        if ($request->name != null) {
            $post = $post->where('name', 'LIKE', "%{$request->name}%");
        }
        $post = $post->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $post;
    }

    public function getListCategoryPost()
    {
        $listCategoryPost = CategoryPost::select(
            'id',
            'name',
            'parent_id'
        )
            ->where('parent_id', 0)
            ->paginate(self::PAGINATE);
        return $listCategoryPost;
    }

    public function getPostById($id)
    {
        $post = Post::findOrFail($id);
        return $post;
    }

    public function createPost($request)
    {
        $user_id = Auth::id();
        $post = new Post();
        $post->name = $request->name;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->description_seo = $request->description_seo ?? null;
        $post->keyword_seo = $request->keyword_seo ?? null;
        $post->title_seo = $request->title_seo ?? null;
        $post->content = $request->content ?? null;
        $post->active = $request->active;
        $post->hot = $request->hot;
        $post->order = $request->order;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/posts');
            $post->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/posts');
            $post->banner_path = Storage::url($path);
        }

        $post->user_id = $user_id;
        $post->setting_id = $request->setting_id ?? null;
        $post->save();
        if ($request->has('category_id')) {
            $post->categories()->sync($request->category_id);
        }
        return true;
    }

    public function updatePost($request, $id)
    {
        $postById = Post::findOrFail($id);

        if (!$postById) {
            return false;
        }

        if ($request->hasFile('image_path')) {
            if ($postById->image_path) {
                $imagePath = 'public/posts/' . basename($postById->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/posts');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $postById->image_path;
        }

        if ($request->hasFile('banner_path')) {
            if ($postById->banner_path) {
                $bannerPath = 'public/posts/' . basename($postById->banner_path);
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            $path = $request->file('banner_path')->store('public/posts');
            $bannerPath = Storage::url($path);
        } else {
            $bannerPath = $postById->banner_path;
        }

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description ?? null,
            'description_seo' => $request->description_seo ?? null,
            'keyword_seo' => $request->keyword_seo ?? null,
            'title_seo' => $request->title_seo ?? null,
            'content' => $request->content ?? null,
            'image_path' => $imagePath,
            'banner_path' => $bannerPath,
            'active' => $request->active,
            'hot' => $request->hot,
            'order' => $request->order,
            'user_id' => Auth::user()->id,
            'setting_id' => $request->setting_id ?? null
        ];

        $postById->update($data);

        if ($request->has('category_id')) {
            $postById->categories()->sync($request->category_id);
        } else {
            $postById->categories()->detach();
        }

        return true;
    }

    public function deletePost($id)
    {
        $postById = Post::findOrFail($id);

        if (!$postById) {
            return false;
        }

        if ($postById->image_path) {
            $imagePath = 'public/posts/' . basename($postById->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($postById->banner_path) {
            $bannerPath = 'public/posts/' . basename($postById->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $postById->delete();
        return true;
    }

}
