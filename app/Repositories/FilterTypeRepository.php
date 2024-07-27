<?php

namespace App\Repositories;

use App\Models\FilterType;

class FilterTypeRepository{
    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListFilterType($request)
    {
        $filterType = FilterType::query();
        if ($request->name != null) {
            $filterType = $filterType->where('name', 'LIKE', "%{$request->name}%");
        }
        $filterType = $filterType->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $filterType;
    }

    public function getFilterTypeById($id)
    {
        $filterType = FilterType::find($id);
        return $filterType;
    }

    public function createFilterType($request)
    {
        $filterType = new FilterType();
        $filterType->name = $request->name;
        $filterType->save();
        return true;
    }

    public function updateFilterType($request, $id)
    {
        $filterType = FilterType::find($id);
        $filterType->name = $request->name;
        $filterType->save();
        return true;
    }

    public function deleteFilterType($id)
    {
        $filterType = FilterType::find($id);
        $filterType->delete();
        return true;
    }
}
