<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingRepository
{
    const PAGINATE = 15;

    const PAGINATE_FILE = 5;

    public function getAllSetting($request)
    {
        $setting = Setting::select(
                'settings.id',
                'settings.name',
                'settings.slug',
                'settings.image_path',
                'settings.banner_path',
                'settings.order',
                'settings.active',
                'settings.hot',
                'settings.parent_id',
                'settings.type',
                DB::Raw('COUNT(child.id) as child_count')
            );

        if ($request->name != null) {
            $setting = $setting->where('settings.name', 'LIKE', "%{$request->name}%");
        } else {
            $setting = $setting->where('settings.parent_id', 0)
                ->whereNull('settings.deleted_at');
        }

        $setting = $setting->leftJoin('settings as child', function ($join) {
                $join->on('settings.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('settings.id')
            ->orderBy('settings.id', 'DESC')
            ->paginate(self::PAGINATE);

        return $setting;
    }

    public function getSettingByIdCate($id)
    {
        $setting = Setting::select(
            'settings.id',
            'settings.name',
            'settings.slug',
            'settings.image_path',
            'settings.banner_path',
            'settings.order',
            'settings.active',
            'settings.hot',
            'settings.parent_id',
            'settings.type',
            DB::Raw('COUNT(child.id) as child_count')
        )
            ->where('settings.parent_id', $id)
            ->whereNull('settings.deleted_at')
            ->leftJoin('settings as child', function($join) {
                $join->on('settings.id', '=', 'child.parent_id')
                    ->whereNull('child.deleted_at');
            })
            ->groupBy('settings.id')
            ->orderBy('settings.id', 'DESC')
            ->paginate(self::PAGINATE);
        return $setting;
    }

    public function getSettingById($id)
    {
        $setting = Setting::findOrFail($id);
        return $setting;
    }

    public function createSetting($request)
    {
        $setting = new Setting;
        $setting->name = $request->name;
        $setting->slug = $request->slug;
        $setting->description = $request->description;
        $setting->description_seo = $request->description_seo ?? null;
        $setting->keyword_seo = $request->keyword_seo ?? null;
        $setting->title_seo = $request->title_seo ?? null;
        $setting->content = $request->content ?? null;
        $setting->active = $request->active;
        $setting->hot = $request->hot;
        $setting->order = $request->order;
        $setting->parent_id = $request->parent_id ?? 0;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->storePublicly('public/settings');
            $setting->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            $path = $request->file('banner_path')->storePublicly('public/settings');
            $setting->banner_path = Storage::url($path);
        }

        $setting->save();

        return true;
    }

    public function updateSetting($request, $id)
    {
        $settingById = Setting::findOrFail($id);

        if (!$settingById) {
            return false;
        }

        if ($request->hasFile('image_path')) {
            if ($settingById->image_path) {
                $oldImagePath = str_replace('/storage', 'public', $settingById->image_path);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            $path = $request->file('image_path')->storePublicly('public/settings');
            $settingById->image_path = Storage::url($path);
        }

        if ($request->hasFile('banner_path')) {
            if ($settingById->banner_path) {
                $oldBannerPath = str_replace('/storage', 'public', $settingById->banner_path);
                if (Storage::exists($oldBannerPath)) {
                    Storage::delete($oldBannerPath);
                }
            }

            $path = $request->file('banner_path')->storePublicly('public/settings');
            $settingById->banner_path = Storage::url($path);
        }

        $settingById->name = $request->name;
        $settingById->slug = $request->slug;
        $settingById->description = $request->description;
        $settingById->description_seo = $request->description_seo ?? null;
        $settingById->keyword_seo = $request->keyword_seo ?? null;
        $settingById->title_seo = $request->title_seo ?? null;
        $settingById->content = $request->content ?? null;
        $settingById->active = $request->active;
        $settingById->hot = $request->hot;
        $settingById->order = $request->order;
        $settingById->parent_id = $request->parent_id ?? 0;

        $settingById->save();
    }

    public function deleteSetting($id)
    {
        $settingById = Setting::findOrFail($id);

        if (!$settingById) {
            return false;
        }

        foreach ($settingById->childs as $child) {
            $this->deleteSetting($child->id);
        }

        if ($settingById->image_path) {
            $imagePath = 'public/settings/' . basename($settingById->image_path);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        if ($settingById->banner_path) {
            $bannerPath = 'public/settings/' . basename($settingById->banner_path);
            if (Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
        }

        $settingById->delete();

        return true;
    }

}
