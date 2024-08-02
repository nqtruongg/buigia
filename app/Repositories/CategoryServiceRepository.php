<?php

namespace App\Repositories;

use App\Models\CategoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryServiceRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListCategoryService($request)
    {
        $categoryService = CategoryService::select(
            'category_services.id',
            'category_services.name',
            'category_services.slug',
            'category_services.hot',
            'category_services.active',
            'category_services.order',
            'category_services.parent_id',
            'category_services.description',
            'category_services.content',
            DB::raw('COUNT(child.id) as child_count')
        );
        if ($request->name != '') {
            $categoryService = $categoryService->where('category_services.name', 'LIKE', "%{$request->name}%");
        }
        if ($request->hot != '') {
            $categoryService = $categoryService->where('category_services.hot', $request->hot);
        }
        if ($request->active != '') {
            $categoryService = $categoryService->where('category_services.active', $request->active);
        }
        $categoryService = $categoryService
            ->where('category_services.parent_id', 0)
            ->whereNull('category_services.deleted_at')
            ->leftJoin('category_services as child', function ($join) {
                $join->on('category_services.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('category_services.id')
            ->orderBy('category_services.id', 'DESC')
            ->paginate(self::PAGINATE);
        return $categoryService;
    }

    public function getCategoryServiceByCate($id)
    {
        $categoryService = CategoryService::select(
            'category_services.id',
            'category_services.name',
            'category_services.slug',
            'category_services.hot',
            'category_services.active',
            'category_services.order',
            'category_services.parent_id',
            'category_services.description',
            'category_services.content',
            DB::raw('COUNT(child.id) as child_count')
        )->where('category_services.parent_id', $id)
            ->whereNull('category_services.deleted_at')
            ->leftJoin('category_services as child', function ($join) {
                $join->on('category_services.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('category_services.id')
            ->orderBy('category_services.id', 'DESC')
            ->paginate(self::PAGINATE);
        return $categoryService;
    }

    public function getListCategoryServiceParent()
    {
        $categoryService = CategoryService::select(
            'id',
            'name',
            'slug',
            'order',
            'description',
            'content',
            'keyword_seo',
            'title_seo',
            'description_seo',
            'parent_id'
        )->where('parent_id', 0)
            ->orderBy('id', 'DESC')
            ->paginate(self::PAGINATE);
        return $categoryService;
    }

    public function getCategoryServiceById($id)
    {
        $categoryService = CategoryService::find($id);
        return $categoryService;
    }

    public function createCategoryService($request)
    {

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/categoryServices');
            $request->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/categoryServices');
            $request->banner_path = Storage::url($path);
        }
        $categoryService = new CategoryService();
        $categoryService->name = $request->name;
        $categoryService->slug = $request->slug;
        $categoryService->image_path = $request->image_path ?? '';
        $categoryService->banner_path = $request->banner_path ?? '';
        $categoryService->order = $request->order;
        $categoryService->description = $request->description ?? '';
        $categoryService->content = $request->content ?? '';
        $categoryService->keyword_seo = $request->keyword_seo ?? '';
        $categoryService->title_seo = $request->title_seo ?? '';
        $categoryService->description_seo = $request->description_seo ?? '';
        $categoryService->parent_id = $request->parent_id ?? 0;
        $categoryService->save();
        return $categoryService;
    }

    public function updateCategoryService($request, $id)
    {
        $categoryService = CategoryService::find($id);

        if ($request->hasFile('image_path')) {
            if ($categoryService->image_path) {
                $imagePath = 'public/categoryServices/' . basename($categoryService->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/categoryServices');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $categoryService->image_path;
        }

        if ($request->hasFile('banner_path')) {
            if ($categoryService->banner_path) {
                $bannerPath = 'public/categoryServices/' . basename($categoryService->banner_path);
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            $path = $request->file('banner_path')->store('public/categoryServices');
            $bannerPath = Storage::url($path);
        } else {
            $bannerPath = $categoryService->image_path;
        }
        $categoryService->name = $request->name;
        $categoryService->slug = $request->slug;
        $categoryService->image_path = $imagePath;
        $categoryService->banner_path = $bannerPath;
        $categoryService->order = $request->order;
        $categoryService->description = $request->description ?? '';
        $categoryService->content = $request->content ?? '';
        $categoryService->keyword_seo = $request->keyword_seo ?? '';
        $categoryService->title_seo = $request->title_seo ?? '';
        $categoryService->description_seo = $request->description_seo ?? '';
        $categoryService->parent_id = $request->parent_id ?? 0;
        $categoryService->save();
        return $categoryService;
    }

    public function deleteCategoryService($id)
    {
        $categoryService = CategoryService::find($id);

        if ($categoryService->image_path) {
            $imagePath = 'public/categoryServices/' . basename($categoryService->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($categoryService->banner_path) {
            $bannerPath = 'public/categoryServices/' . basename($categoryService->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $categoryService->delete();
        return $categoryService;
    }
}
