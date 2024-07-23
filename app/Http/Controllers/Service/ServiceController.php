<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Services\ServeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    private $serviceService;

    public function __construct(ServeService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index(Request $request)
    {
        $services = $this->serviceService->getListService($request);
        return view('service.index', compact('services'));
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->serviceService->createService($request);
            DB::commit();
            return redirect()->route('service.index')->with([
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
        $service = $this->serviceService->getServiceById($id);
        return view('service.edit', compact('service'));
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->serviceService->updateService($request, $id);
            DB::commit();
            return redirect()->route('service.index')->with([
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
            $service = Service::find($id);
            if ($service) {
                DB::beginTransaction();
                $service->delete();
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
