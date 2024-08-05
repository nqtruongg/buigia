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

    public function getAllCities($request)
    {
        $cities = City::select(
            'cities.id',
            'cities.name',
            'cities.type',
            'cities.active',
            DB::raw('COUNT(districts.id) as child_count')
        );

        if ($request->name != '') {
            $cities = $cities->where('cities.name', 'LIKE', "%{$request->name}%");
        }

        $cities = $cities->leftJoin('districts', 'cities.id', '=', 'districts.city_id')
            ->groupBy('cities.id', 'cities.name', 'cities.type')
            ->orderBy('cities.id', 'ASC')
            ->paginate(self::PAGINATE);

        return $cities;

    }

    public function getAllDistrictByCityId($request, $city_id)
    {
        $districts = District::select(
            'districts.id',
            'districts.name',
            'districts.type',
            'districts.active',
            'districts.city_id',
            DB::raw('COUNT(communes.id) as child_count')
        );

        if ($request->name != '') {
            $districts = $districts->where('districts.name', 'LIKE', "%{$request->name}%");
        }

        $districts = $districts->where('city_id', $city_id)
            ->leftJoin('communes', 'districts.id', '=', 'communes.district_id')
            ->groupBy('districts.id', 'districts.name', 'districts.type', 'districts.city_id')
            ->orderBy('districts.id', 'ASC')
            ->paginate(self::PAGINATE);
        return $districts;
    }

    public function getAllCommunesByCityId($request, $district_id)
    {
        $communes = Commune::select('id', 'name', 'type','active', 'district_id');
        if ($request->name != '') {
            $communes = $communes->where('name', 'LIKE', "%{$request->name}%");
        }
        $communes = $communes->where('district_id', $district_id)
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

    public function getCityById($id)
    {
        $city = City::find($id);
        return $city;
    }

    public function getDistrictById($cityId, $id)
    {
        $district = District::where('city_id', $cityId)->find($id);
        return $district;
    }

    public function getCommuneById($districtId, $id)
    {
        $commune = Commune::where('district_id', $districtId)->find($id);
        return $commune;
    }

    public function updateCityById($request, $id)
    {
        $city = City::find($id);
        $city->name = $request->name;
        $city->type = $request->type;
        $city->active = $request->active;
        $city->save();
        return true;
    }

    public function updateDistrictById($request, $cityId, $id)
    {
        $district = District::where('city_id', $cityId)->find($id);
        $district->name = $request->name;
        $district->type = $request->type;
        $district->active = $request->active;
        $district->city_id = $request->city_id;
        $district->save();
        return true;
    }

    public function updateCommuneById($request, $districtId, $id)
    {
        $commune = Commune::where('district_id', $districtId)->find($id);
        $commune->name = $request->name;
        $commune->type = $request->type;
        $commune->active = $request->active;
        $commune->district_id = $request->district_id;
        $commune->save();
        return true;
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

    public function createCity($request)
    {
        $area = new City();
        $area->name = $request->name;
        $area->type = $request->type;
        $area->active = $request->active ?? 1;
        $area->save();
        return true;
    }

    public function createDistrict($request)
    {
        $area = new District();
        $area->name = $request->name;
        $area->type = $request->type;
        $area->active = $request->active ?? 1;
        $area->city_id = $request->city_id;
        $area->save();
        return true;
    }

    public function createCommune($request)
    {
        $area = new Commune();
        $area->name = $request->name;
        $area->type = $request->type;
        $area->active = $request->active ?? 1;
        $area->district_id = $request->district_id;
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
