<?php

namespace App\Http\Controllers\HouseHolder;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseHolderRequest;
use App\Models\HouseHolder;
use App\Services\HouseHolderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HouseHolderController extends Controller
{
    private $houseHolderService;

    public function __construct(HouseHolderService $houseHolderService)
    {
        $this->houseHolderService = $houseHolderService;
    }

    public function index (Request $request)
    {
        $houseHolders = $this->houseHolderService->getListHouseHolder($request);
        return view('householder.index', compact('houseHolders'));
    }

    public function create()
    {
        return view('householder.create');
    }

    public function store(HouseHolderRequest $request)
    {
        try{
            DB::beginTransaction();
            $this->houseHolderService->createHouseHolder($request);
            DB::commit();
            return redirect()->route('householder.index')->with([
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
        $houseHolder = $this->houseHolderService->getHouseHolderById($id);
        return view('householder.edit', compact('houseHolder'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->houseHolderService->updateHouseHolder($request, $id);
            DB::commit();
            return redirect()->route('householder.index')->with([
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

    public function delete($id){
        try {
            $house_holder = HouseHolder::find($id);
            if ($house_holder) {
                DB::beginTransaction();
                $house_holder->delete();
                DB::commit();
                return [
                    'status' => 200,
                    'msg' => [
                        'text' => trans('message.success'),
                    ],
                ];
            }
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
