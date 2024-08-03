<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Services\CategoryServiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryServiceController extends Controller
{
    private $categoryService;

    public function __construct(CategoryServiService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categoryServices = $this->categoryService->getListCategoryService($request);

        $listCategoryServiceByCate = $this->categoryService->getCategoryServiceByCate($request, $request->query('parent_id'));

        return view('category-service.index', compact('categoryServices', 'listCategoryServiceByCate'));
    }

    public function create()
    {
        $listCateCategoryService = $this->categoryService->getListCategoryServiceParent();
        return view('category-service.create', compact('listCateCategoryService'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->categoryService->createCategoryService($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('categoryService.index') . '?parent_id=' . $request->parent_id :
                route('categoryService.index');

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
        $categoryService = $this->categoryService->getCategoryServiceById($id);
        $listCateCategoryService = $this->categoryService->getListCategoryServiceParent();
        return view('category-service.edit', compact('categoryService', 'listCateCategoryService'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->categoryService->updateCategoryService($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('categoryService.index') . '?parent_id=' . $request->parent_id :
                route('categoryService.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_service_success')
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
            $this->categoryService->deleteCategoryService($id);
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
    public function changeActive(Request $request)
    {
        $item = CategoryService::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = CategoryService::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
