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

    public function getListPost()
    {
        $post = Post::select(
            'id',
            'name',
            'description',
            'image_path',
            'slug',
            'hot',
            'active',
            'order',
            'category_id'
        )
            ->orderBy('id', 'DESC')
            ->paginate(self::PAGINATE);
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

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/post');
            $request->merge(['image_path' => Storage::url($path)]);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/post');
            $request->merge(['banner_path' => Storage::url($path)]);
        }

        $data = $request->only([
            'name',
            'slug',
            'description',
            'description_seo',
            'keyword_seo',
            'title_seo',
            'content',
            'image_path',
            'banner_path',
            'active',
            'hot',
            'order',
        ]);

        $data['user_id'] = Auth::id();

        $post = Post::create($data);

        if ($request->has('category_id')) {
            $post->categories()->sync($request->category_id);
        }

        return true;
    }

    public function updatePost($request, $id)
    {
        $postById = Post::findOrFail($id);

        if(!$postById) {
            return false;
        }

        if ($request->hasFile('image_path')) {
            if ($postById->image_path) {
                $imagePath = 'public/post/' . basename($postById->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/post');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $postById->image_path;
        }

        if ($request->hasFile('banner_path')) {
            if ($postById->banner_path) {
                $bannerPath = 'public/post/' . basename($postById->banner_path);
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            $path = $request->file('banner_path')->store('public/post');
            $bannerPath = Storage::url($path);
        } else {
            $bannerPath = $postById->banner_path;
        }

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'description_seo' => $request->description_seo,
            'keyword_seo' => $request->keyword_seo,
            'title_seo' => $request->title_seo,
            'content' => $request->content,
            'image_path' => $imagePath,
            'banner_path' => $bannerPath,
            'active' => $request->active,
            'hot' => $request->hot,
            'order' => $request->order,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
            'setting_id' => $request->setting_id
        ];

        $postById->update($data);

        $postCate = PostCate::where('post_id', $postById->id)->first();

        if ($postCate) {
            $postCate->update([
                'category_id' => $request->category_id
            ]);
        } else {
            PostCate::create([
                'post_id' => $postById->id,
                'category_id' => $request->category_id
            ]);
        }

        return true;
    }

    public function deletePost($id)
    {
        $postById = Post::findOrFail($id);

        if(!$postById) {
            return false;
        }

        if ($postById->image_path) {
            $imagePath = 'public/post/' . basename($postById->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($postById->banner_path) {
            $bannerPath = 'public/post/' . basename($postById->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $postById->delete();
        return true;
    }

}
