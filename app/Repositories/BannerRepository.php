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

    public function getListBannerIndex($request){
        $banner = Banner::all();
        return $banner;
    }

    public function getBannerById($id){
        $banner = Banner::find($id);
        return $banner;
    }

    public function createBanner($request){
        $banner = new Banner();
        $banner->name = $request->name;
        $banner->share_id = $request->share_id;
        $banner->language = $request->language;
        $banner->link = $request->link;
        $banner->hot = $request->hot;
        $banner->active = $request->active;
        $banner->order = $request->order;
        $banner->description = $request->description;
        $banner->image_path = $request->image_path;
        $banner->parent_id = $request->parent_id;
        $banner->save();
        return true;
    }

    public function updateBanner($request, $id){
        $banner = Banner::find($id);
        $banner->name = $request->name;
        $banner->share_id = $request->share_id;
        $banner->language = $request->language;
        $banner->link = $request->link;
        $banner->hot = $request->hot;
        $banner->active = $request->active;
        $banner->order = $request->order;
        $banner->description = $request->description;
        $banner->image_path = $request->image_path;
        $banner->parent_id = $request->parent_id;
        $banner->save();
        return true;
    }

    public function deleteBanner($id){
        $banner = Banner::find($id);
        if($banner){
            $banner->delete();
            return true;
        }
        return false;
    }

}

