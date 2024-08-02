<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class BannerRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListBannerIndex($request)
    {
        $banner = Banner::select(
            'banners.id',
            'banners.name',
            'banners.slug',
            'banners.hot',
            'banners.active',
            'banners.order',
            'banners.parent_id',
            'banners.description',
            DB::raw('COUNT(child.id) as child_count')
        );

        if ($request->name != '') {
            $banner = $banner->where('banners.name', 'LIKE', "%{$request->name}%");
        } else {
            $banner = $banner->where('banners.parent_id', 0)
                ->whereNull('banners.deleted_at');
        }

        if($request->active != ''){
            $banner = $banner->where('banners.active', $request->active);
        }
        if($request->hot != ''){
            $banner = $banner->where('banners.hot', $request->hot);
        }

        $banner = $banner->where('banners.parent_id', 0)
            ->whereNull('banners.deleted_at')
            ->leftJoin('banners as child', function($join) {
                $join->on('banners.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('banners.id')
            ->orderBy('banners.id', 'DESC')
            ->paginate(self::PAGINATE);
        return $banner;
    }

    public function getAllParentCate()
    {
        $dataParentCate = Banner::with('childrenRecursive')
            ->where('parent_id', 0)
            ->paginate(self::PAGINATE);
        return $dataParentCate;
    }

    public function getBannerById($id)
    {
        $banner = Banner::find($id);
        return $banner;
    }

    public function getBannerByIdCate($id, $request)
    {
        $banner = Banner::select(
            'banners.id',
            'banners.name',
            'banners.slug',
            'banners.hot',
            'banners.active',
            'banners.order',
            'banners.parent_id',
            'banners.description',
            DB::raw('COUNT(child.id) as child_count')
        )->where('banners.parent_id', $id)
            ->whereNull('banners.deleted_at')
            ->leftJoin('banners as child', function($join) {
                $join->on('banners.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('banners.id')
            ->orderBy('banners.id', 'DESC')->paginate(self::PAGINATE);
        return $banner;
    }

    public function createBanner($request)
    {

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->slug = $request->slug;
        $banner->link = $request->link;
        $banner->hot = $request->hot;
        $banner->active = $request->active;
        $banner->order = $request->order;
        $banner->description = $request->description;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/banners');
            $banner->image_path = Storage::url($path);
        }

        $banner->parent_id = $request->parent_id ?? 0;

        $banner->save();

        return true;
    }

    public function updateBanner($request, $id)
    {

        $banner = Banner::find($id);

        $banner->name = $request->name;
        $banner->share_id = $request->share_id;
        $banner->slug = $request->slug;
        $banner->language = $request->language;
        $banner->link = $request->link;
        $banner->hot = $request->hot;
        $banner->active = $request->active;
        $banner->order = $request->order;
        $banner->description = $request->description;


        if ($request->hasFile('image_path')) {
            if ($banner->image_path) {
                $imagePath = 'public/banners/' . basename($banner->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            $path = $request->file('image_path')->storePublicly('public/banners');
            $banner->image_path = Storage::url($path);
        }

        $banner->parent_id = $request->parent_id ?? 0;
        $banner->save();
        return true;
    }

    public function deleteBanner($id){
        $banner = Banner::find($id);

        foreach ($banner->childs as $child) {
            $this->deleteBanner($child->id);
        }

        if ($banner->image_path) {
            $imagePath = 'public/banners/' . basename($banner->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        $banner->delete();
        return true;
    }

}

