<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
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
        $banner = $this->bannerService->getListBannerIndex($request);
        return response()->json($banner);
    }

    public function detail($id)
    {
        $banner = $this->bannerService->getBannerById($id);
        return response()->json($banner);
    }

    public function create(Request $request)
    {
        //return view
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->bannerService->createBanner($request);
            DB::commit();
            //return
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
        //return view
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->bannerService->updateBanner($request, $id);
            DB::commit();
            //return
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
            //return
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
