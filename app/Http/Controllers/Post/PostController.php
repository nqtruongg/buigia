<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listPost = $this->postService->getListPost($request);
        return view('post.index', compact('listPost'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listCategoryPost = $this->postService->getListCategoryPost();
        return view('post.create', compact('listCategoryPost'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->postService->createPost($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('post.index') . '?parent_id=' . $request->parent_id :
                route('post.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_post_success')
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
        return view('post.detail');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = $this->postService->getPostById($id);

        $listCategoryPost = $this->postService->getListCategoryPost();

        $selectedCategoryIds = $post->categories->pluck('id')->toArray();

        return view('post.edit', compact('post', 'listCategoryPost', 'selectedCategoryIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->postService->updatePost($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('post.index') . '?parent_id=' . $request->parent_id :
                route('post.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_post_success')
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
    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $this->postService->deletePost($id);
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
        $item = Post::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = Post::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
