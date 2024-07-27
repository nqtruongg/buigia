<?php
namespace App\Repositories;

use App\Models\Filter;
use App\Models\FilterType;

class FilterRepository
{

    const PAGINATE = 15;
    const PAGINATE_FILE = 5;

    public function getListFilter($request)
    {
        $filter = Filter::query();
        if ($request->name != null) {
            $filter = $filter->where('name', 'LIKE', "%{$request->name}%");
        }
        $filter = $filter->orderBy('id', 'desc')->paginate(self::PAGINATE);
        return $filter;
    }

    public function getListFilterType(){
        $filterType = FilterType::all();
        return $filterType;
    }

    public function getFilterById($id)
    {
        $filter = Filter::find($id);
        return $filter;
    }

    public function createFilter($request)
    {
        // dd($request->all());
        $filter = new Filter();
        $filter->filter_type_id = $request->filter_type_id;
        $filter->min_value = $request->min_value ?? null;
        $filter->max_value = $request->max_value ?? null;
        $filter->exact_value = $request->exact_value ?? null;
        $filter->direction = $request->direction ?? null;
        $filter->save();
        return true;
    }

    public function updateFilter($request, $id)
    {
        $filter = Filter::find($id);
        $filter->filter_type_id = $request->filter_type_id;
        $filter->min_value = $request->min_value ?? null;
        $filter->max_value = $request->max_value ?? null;
        $filter->exact_value = $request->exact_value ?? null;
        $filter->direction = $request->direction ?? null;
        $filter->save();
        return true;
    }

    public function deleteFilter($id)
    {
        $filter = Filter::find($id);
        $filter->delete();
        return true;
    }
}
