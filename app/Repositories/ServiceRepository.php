<?php

namespace App\Repositories;

use App\Models\Area;
use App\Models\CategoryService;
use App\Models\Department;
use App\Models\HouseHolder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ServiceRepository
{
    const PAGINATE = 15;

    public function getListService($request)
    {
        $services = Service::select('id', 'name', 'price', 'description', 'type');

        if($request->name != null){
            $services = $services->where('name', 'LIKE', "%{$request->name}%");
        }

        $services = $services->paginate(self::PAGINATE);
        return $services;
    }

    public function getAllArea()
    {
        $area = Area::select(
            'id',
            'name',
            'active',
            'hot',
            'order',
            'parent_id'
        )->where('parent_id', 0)
            ->orderBy('id', 'DESC')
            ->paginate(self::PAGINATE);
        return $area;
    }

    public function getListHouseHolder()
    {
        $houseHolders = HouseHolder::query();

        $houseHolders = $houseHolders->paginate(self::PAGINATE);

        return $houseHolders;
    }

    public function getListCategoryService()
    {
        $categoryService = CategoryService::query();

        $categoryService = $categoryService->where('parent_id', 0)
            ->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $categoryService;
    }

    public function createService($request)
    {
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/services');
            $request->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/services');
            $request->banner_path = Storage::url($path);
        }

        $service = Service::create([
            'name' => $request->name,
            'slug' => $request->slug ?? null,
            'price' => str_replace(',', '', $request->price),
            'type' => $request->type,
            'image_path' => $request->image_path ?? null,
            'banner_path' => $request->banner_path ?? null,
            'acreage' => $request->acreage,
            'numberBedroom' => $request->numberBedroom,
            'toilet' => $request->toilet,
            'direction' => $request->direction,
            'area_id' => $request->area,
            'householder_id' => $request->houseHolder,
            'description' => $request->description,
            'description_seo' => $request->description_seo ?? null,
            'keyword_seo' => $request->keyword_seo ?? null,
            'title_seo' => $request->title_seo ?? null,
            'content' => $request->content ?? null,
            'active' => $request->active ?? 1,
            'hot' => $request->hot ?? 0,
            'order' => $request->order ?? 0,
        ]);

        if ($request->has('category_id')) {
            $service->categories()->sync($request->category_id);
        }

        $relatedPhotos = [];
        foreach ($request->file('relatedPhotos') as $file) {
            $path = $file->storePublicly('public/services');
            $relatedPhotos[] = ['related_photo' => Storage::url($path)];
        }

        $service->serviceImages()->createMany($relatedPhotos);

        return true;
    }

    public function getServiceById($id)
    {
        $service = Service::with('serviceImages')->findOrFail($id);
        return $service;
    }

    public function updateService($request, $id)
    {
        $service = Service::findOrFail($id);

        if ($request->hasFile('image_path')) {
            if ($service->image_path) {
                $imagePath = 'public/services/' . basename($service->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->store('public/services');
            $imagePath = Storage::url($path);
        } else {
            $imagePath = $service->image_path;
        }

        if ($request->hasFile('banner_path')) {
            if ($service->banner_path) {
                $bannerPath = 'public/services/' . basename($service->banner_path);
                if (Storage::exists($bannerPath)) {
                    Storage::delete($bannerPath);
                }
            }

            $path = $request->file('banner_path')->store('public/services');
            $bannerPath = Storage::url($path);
        } else {
            $bannerPath = $service->banner_path;
        }

        $service->update([
            'name' => $request->name,
            'price' => str_replace(',', '', $request->price),
            'type' => $request->type,
            'description' => $request->description,
            'slug' => $request->slug ?? $service->slug,
            'acreage' => $request->acreage ?? $service->acreage,
            'numberBedroom' => $request->numberBedroom ?? $service->numberBedroom,
            'toilet' => $request->toilet ?? $service->toilet,
            'image_path' => $imagePath,
            'banner_path' => $bannerPath,
            'direction' => $request->direction ?? $service->direction,
            'area_id' => $request->area ?? $service->area_id,
            'householder_id' => $request->houseHolder ?? $service->householder_id,
            'description_seo' => $request->description_seo ?? $service->description_seo,
            'keyword_seo' => $request->keyword_seo ?? $service->keyword_seo,
            'title_seo' => $request->title_seo ?? $service->title_seo,
            'content' => $request->content ?? $service->content,
            'active' => $request->active ?? $service->active,
            'hot' => $request->hot ?? $service->hot,
            'order' => $request->order ?? $service->order,
        ]);

        if ($request->has('category_id')) {
            $service->categories()->sync($request->category_id);
        }

        if ($request->hasFile('relatedPhotos')) {
            $service->serviceImages()->each(function ($image) {
                $oldPhotoPath = str_replace('/storage/', 'public/', $image->related_photo);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            });

            $service->serviceImages()->delete();

            $relatedPhotos = [];
            foreach ($request->file('relatedPhotos') as $file) {
                $path = $file->storePublicly('public/services');
                $relatedPhotos[] = ['related_photo' => Storage::url($path)];
            }

            $service->serviceImages()->createMany($relatedPhotos);
        }

        return true;
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);

        if(!$service){
            return false;
        }

        if ($service->image_path) {
            $imagePath = 'public/services/' . basename($service->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($service->banner_path) {
            $bannerPath = 'public/services/' . basename($service->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $service->categories()->detach();

        $service->serviceImages()->each(function ($image) {
            $relatedPhotoPath = str_replace('/storage/', 'public/', $image->related_photo);

            if ($relatedPhotoPath) {
                if (Storage::exists($relatedPhotoPath)) {
                    Storage::delete($relatedPhotoPath);
                } else {
                    Log::warning("Không tìm thấy hình ảnh: {$relatedPhotoPath}");
                }
            } else {
                Log::warning("Không tìm thấy đường dẫn: {$image->id}");
            }

            $image->delete();
        });

        $service->delete();

        return true;
    }

    public function destroyImage($id)
    {
        $image = ServiceImage::findOrFail($id);

        if(!$image){
            return response()->json([
                'deleted' => false,
                'message' => 'Không tìm thấy hình ảnh'
            ], 404);
        }

        $imagePath = 'public/services/' . basename($image->related_photo);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $image->delete();

        return true;
    }
}
