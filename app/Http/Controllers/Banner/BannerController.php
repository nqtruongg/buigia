<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $parentBanner = $this->bannerService->getAllParentCate();

        $listBanner = $this->bannerService->getListBannerIndex($request);

        $listBannerByCate = $this->bannerService->getBannerByIdCate($request->query('parent_id'), $request);

        return view('banner.list', compact('parentBanner', 'listBanner', 'listBannerByCate'));
    }

    public function detail($id)
    {
        $banner = $this->bannerService->getBannerById($id);
        return view('banner.detail');
    }

    public function create(Request $request)
    {
        $parentBanner = $this->bannerService->getAllParentCate();

        return view('banner.create', compact('parentBanner'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->bannerService->createBanner($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('banner.index') . '?parent_id=' . $request->parent_id :
                route('banner.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_banner_success')
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
        $banner = $this->bannerService->getBannerById($id);

        $parentBanner = $this->bannerService->getAllParentCate();

        return view('banner.edit', compact('parentBanner', 'banner'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->bannerService->updateBanner($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('banner.index') . '?parent_id=' . $request->parent_id :
                route('banner.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_banner_success')
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
            $this->bannerService->deleteBanner($id);
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
        $item = Banner::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = Banner::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
