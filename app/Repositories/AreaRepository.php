<?php

namespace App\Repositories;

use App\Models\Area;
use App\Models\City;
use App\Models\Commune;
use App\Models\District;
use Illuminate\Support\Facades\DB;

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

    public function getAllCities()
    {
        $cities = City::select(
            'cities.id',
            'cities.name',
            'cities.type',
            DB::raw('COUNT(districts.id) as child_count')
        )
            ->leftJoin('districts', 'cities.id', '=', 'districts.city_id')
            ->groupBy('cities.id', 'cities.name', 'cities.type')
            ->orderBy('cities.id', 'ASC')
            ->paginate(self::PAGINATE);

        return $cities;

    }

    public function getAllDistrictByCityId($city_id)
    {
        $districts = District::select(
            'districts.id',
            'districts.name',
            'districts.type',
            'districts.city_id',
            DB::raw('COUNT(communes.id) as child_count')
        )
            ->where('city_id', $city_id)
            ->leftJoin('communes', 'districts.id', '=', 'communes.district_id')
            ->groupBy('districts.id', 'districts.name', 'districts.type', 'districts.city_id')
            ->orderBy('districts.id', 'ASC')
            ->paginate(self::PAGINATE);
        return $districts;
    }

    public function getAllCommunesByCityId($district_id)
    {
        $communes = Commune::select('id', 'name', 'type', 'district_id')
            ->where('district_id', $district_id)
            ->paginate(self::PAGINATE);
        return $communes;
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
