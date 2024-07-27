<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{
    private $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $filters = $this->filterService->getListFilter($request);

        return view('filter.index', compact('filters'));
    }

    public function create()
    {
        $filterTypes = $this->filterService->getListFilterType();
        return view('filter.create', compact('filterTypes'));
    }

    public function store(FilterRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->filterService->createFilter($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('filter.index') . '?parent_id=' . $request->parent_id :
                route('filter.index');


            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_filter_success')
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
        $filter = $this->filterService->getFilterById($id);
        $filterTypes = $this->filterService->getListFilterType();
        return view('filter.edit', compact('filter', 'filterTypes'));
    }

    public function update(FilterRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->filterService->updateFilter($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('filter.index') . '?parent_id=' . $request->parent_id :
                route('filter.index');


            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_filter_success')
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->filterService->deleteFilter($id);
            DB::commit();
            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }
}
