<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterTypeRequest;
use App\Services\FilterTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FilterTypeController extends Controller
{
    private $filterTypeService;

    public function __construct(FilterTypeService $filterTypeService)
    {
        $this->filterTypeService = $filterTypeService;
    }

    public function index(Request $request)
    {
        $filterTypes = $this->filterTypeService->getListFilterType($request);

        return view('filter_type.index', compact('filterTypes'));
    }

    public function create()
    {
        return view('filter_type.create');
    }

    public function store(FilterTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->filterTypeService->createFilterType($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('filter_type.index') . '?parent_id=' . $request->parent_id :
                route('filter_type.index');


            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_service_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function edit($id)
    {
        $filterType = $this->filterTypeService->getFilterTypeById($id);

        return view('filter_type.edit', compact('filterType'));
    }

    public function update(FilterTypeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->filterTypeService->updateFilterType($request, $id);
            DB::commit();
            $redirectUrl = $request->parent_id ?
                route('filter_type.index') . '?parent_id=' . $request->parent_id :
                route('filter_type.index');


            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_service_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }
}
