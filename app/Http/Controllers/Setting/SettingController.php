<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listSetting = $this->settingService->getAllSetting($request);

        $listSettingByIdCate = $this->settingService->getSettingByIdCate($request, $request->query('parent_id'));

        return view('setting.index', compact('listSetting', 'listSettingByIdCate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $listSetting = $this->settingService->getAllSetting($request);

        return view('setting.create', compact('listSetting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->settingService->createSetting($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('setting.index') . '?parent_id=' . $request->parent_id :
                route('setting.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.create_setting_success')
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
        return view('setting.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = $this->settingService->getSettingById($id);

        $listSetting = $this->settingService->getAllSetting();

        return view('setting.edit', compact('setting', 'listSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->settingService->updateSetting($request, $id);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('setting.index') . '?parent_id=' . $request->parent_id :
                route('setting.index');

            return redirect($redirectUrl)->with([
                'status_succeed' => trans('message.update_setting_success')
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
            $this->settingService->deleteSetting($id);
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
        $item = Setting::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = Setting::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
