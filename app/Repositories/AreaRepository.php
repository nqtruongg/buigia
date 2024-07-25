<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository
{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListParentArea()
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

    public function getAreaByCate($id)
    {
        $area = Area::where('parent_id', $id)
            ->paginate(self::PAGINATE);
        return $area;
    }

    public function getListArea($request)
    {
        $area = Area::query();
        if ($request->name != null) {
            $area = $area->where('name', 'LIKE', "%{$request->name}%");
        }
        $area = $area->where('parent_id', 0)
            ->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $area;
    }

    public function getAreaById($id)
    {
        $area = Area::find($id);
        return $area;
    }

    public function createArea($request)
    {
        $area = new Area();
        $area->name = $request->name;
        $area->city_id = $request->city_id;
        $area->district_id = $request->district_id;
        $area->commune_id = $request->commune_id;
        $area->address = $request->address ?? '';
        $area->parent_id = $request->parent_id ?? 0;
        $area->slug = $request->slug;
        $area->order = $request->order;
        $area->save();
        return true;
    }

    public function updateArea($request, $id)
    {
        $area = Area::find($id);
        $area->name = $request->name;
        $area->city_id = $request->city_id;
        $area->district_id = $request->district_id;
        $area->commune_id = $request->commune_id;
        $area->parent_id = $request->parent_id ?? 0;
        $area->slug = $request->slug;
        $area->order = $request->order;
        $area->save();
        return true;
    }

    public function deleteArea($id)
    {
        $area = Area::find($id);
        $area->delete();
        return true;
    }
}
