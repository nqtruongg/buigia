<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequest;
use App\Models\Area;
use App\Services\AreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    private $areaService;
    private $areaAddress;

    public function __construct(AreaService $areaService, AddressController $areaAddress)
    {
        $this->areaService = $areaService;
        $this->areaAddress = $areaAddress;
    }

    public function index(Request $request)
    {
//        $areas = $this->areaService->getListArea($request);
//
//        $listAreaByCate = $this->areaService->getAreaByCate($request->query('parent_id'));

        $cityId = $request->get('city_id');
        $districtId = $request->get('district_id');

        if (!empty($districtId)) {
            $communes = $this->areaService->getAllCommunesByCityId($request, $districtId);
            return view('area.index', compact('communes'));
        } elseif (!empty($cityId)) {
            $districts = $this->areaService->getAllDistrictByCityId($request, $cityId);
            return view('area.index', compact('districts'));
        } else {
            $cities = $this->areaService->getAllCities($request);
            return view('area.index', compact('cities'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listCateArea = $this->areaService->getListParentArea();
        return view('area.create', compact('listCateArea'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->areaService->createArea($request);
            DB::commit();

            $redirectUrl = $request->parent_id ?
                route('area.index') . '?parent_id=' . $request->parent_id :
                route('area.index');


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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $area = $this->areaService->getAreaById($id);
        $listCateArea = $this->areaService->getListParentArea();
        // $districts = $this->areaAddress->getDistricts($area->city_id);
        return view('area.edit', compact('area', 'listCateArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->areaService->updateArea($request, $id);
            DB::commit();
            return redirect()->route('area.index')->with([
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

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->areaService->deleteArea($id);
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
        $item = Area::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newStatus' => $item->active]);
    }
    public function changeHot(Request $request)
    {
        $item = Area::find($request->id);
        $item->hot = $item->hot == 1 ? 0 : 1;
        $item->save();

        return response()->json(['newHot' => $item->hot]);
    }
}
