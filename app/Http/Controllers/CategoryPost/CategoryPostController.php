<?php

namespace App\Http\Controllers\CategoryPost;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryPostRequest;
use App\Models\CategoryPost;
use App\Services\CategoryPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryPostController extends Controller
{
    protected $categoryPostService;

    public function __construct(CategoryPostService $categoryPostService)
    {
        $this->categoryPostService = $categoryPostService;
    }

    public function index(Request $request)
    {
        $listCategoryPost = $this->categoryPostService->getListCategoryPost();

        $listCategoryPostByIdCate = $this->categoryPostService->getCategoryPostByIdCate($request->query('parent_id'));

        return view('categorypost.list', compact('listCategoryPost', 'listCategoryPostByIdCate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listCategoryPost = $this->categoryPostService->getListCategoryPost();

        return view('categorypost.create', compact('listCategoryPost'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryPostRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->categoryPostService->createCategoryPost($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('categoryPost.index') . '?parent_id=' . $request->parent_id :
                route('categoryPost.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_category_post_success')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Message: ' . $e->getMessage() . ' ---Line: ' . $e->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoryPostById = $this->categoryPostService->getCategoryPostById($id);
        return view('categorypost.detail', compact('categoryPostById'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listCategoryPost = $this->categoryPostService->getListCategoryPost();

        $categoryPostById = $this->categoryPostService->getCategoryPostById($id);

        return view('categorypost.edit', compact('categoryPostById', 'listCategoryPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryPostRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->categoryPostService->updateCategoryPost($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('categoryPost.index') . '?parent_id=' . $request->parent_id :
                route('categoryPost.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_category_post_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->categoryPostService->deleteCategoryPost($id);
            DB::commit();

            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }
    public function changeActive(Request $request)
    {
        $item = CategoryPost::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = CategoryPost::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
