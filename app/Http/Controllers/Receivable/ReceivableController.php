<?php

namespace App\Http\Controllers\Receivable;

use App\Exports\ReceivableExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReceivableRequest;
use App\Http\Requests\UpdateReceivableRequest;
use App\Models\CustomerService;
use App\Models\Receipt;
use App\Models\Receivable;
use App\Models\Service;
use App\Services\ReceivableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReceivableController extends Controller
{
    private $receivableService;

    public function __construct(ReceivableService $receivableService)
    {
        $this->receivableService = $receivableService;
    }

    public function index(Request $request)
    {
        $receivables = $this->receivableService->getListReceivable($request);
        $services = Service::select('id', 'name')->get();
        return view('receivable.index', compact('receivables', 'services'));
    }

    public function create()
    {
        $customers = $this->receivableService->getListCustomer();
        return view('receivable.create', compact('customers'));
    }

    public function store(ReceivableRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->receivableService->createReceivable($request);
            DB::commit();
            return redirect()->route('receivable.index')->with([
                'status_succeed' => trans('message.create_receivable_success')
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
        $customers = $this->receivableService->getListCustomer();
        $receivable = $this->receivableService->getReceivableById($id);
        $total_advance = $receivable->advance_value_1 + $receivable->advance_value_2 + $receivable->advance_value_3;
        $receipt1 = Receipt::where('receivable_id', $id)->where('type', 1)->first();
        $receipt2 = Receipt::where('receivable_id', $id)->where('type', 2)->first();
        $receipt3 = Receipt::where('receivable_id', $id)->where('type', 3)->first();
        return view('receivable.edit', compact('customers', 'receivable', 'total_advance', 'receipt1', 'receipt2', 'receipt3'));
    }

    public function update(UpdateReceivableRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->receivableService->updateReceivable($request, $id);
            DB::commit();
            return redirect()->route('receivable.index')->with([
                'status_succeed' => trans('message.update_receivable_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function getListService(Request $request)
    {
        if ($request->ajax()) {
            $customer_id = $request->customer_id;
            $services = $this->receivableService->getServiceByCustomer($customer_id);
            return response()->json([
                'code' => 200,
                'services' => $services
            ]);
        }
    }

    public function addForm(Request $request)
    {
        if ($request->ajax()) {
            $service_ids = $request->list_services;
            $html = [];

            // $services = Service::select('id', 'name')->whereIn('id', $service_ids)->get();
            $services = CustomerService::select(
                'services.id',
                'services.name',
                'customer_service.id as customer_service_id',
                'customer_service.ended_at as ended_at',
                'customer_service.subtotal as subtotal',
            )
                ->leftjoin('services', 'services.id', 'customer_service.service_id')
                ->where('customer_service.customer_id', $request->customer_id)
                ->whereIn('customer_service.service_id', $service_ids)
                ->get();
            foreach ($services as $service) {
                $html[] = view('partials.form-receivable', ['service' => $service])->render();
            }

            return response()->json([
                'code' => 200,
                'services' => $services,
                'html' => $html
            ]);
        }
    }

    public function delete($id)
    {
        try {

            DB::beginTransaction();
            Receivable::find($id)->delete();
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

    public function createExtend()
    {
        $customers = $this->receivableService->getListCustomer();
        return view('receivable.extend.create', compact('customers'));
    }

    public function storeExtend(ReceivableRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->receivableService->createReceivableExtend($request);
            DB::commit();
            return redirect()->route('receivable.index')->with([
                'status_succeed' => trans('message.create_receivable_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function editExtend($id)
    {
        $customers = $this->receivableService->getListCustomer();
        $receivable = $this->receivableService->getReceivableById($id);
        $total_advance = $receivable->advance_value_1 + $receivable->advance_value_2 + $receivable->advance_value_3;
        $receipt1 = Receipt::select('id')->where('receivable_id', $id)->where('type', 1)->first();
        $receipt2 = Receipt::select('id')->where('receivable_id', $id)->where('type', 2)->first();
        $receipt3 = Receipt::select('id')->where('receivable_id', $id)->where('type', 3)->first();
        return view('receivable.extend.edit', compact('customers', 'receivable', 'total_advance', 'receipt1', 'receipt2', 'receipt3'));
    }

    public function updateExtend(UpdateReceivableRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->receivableService->updateReceivableExtend($request, $id);
            DB::commit();
            return redirect()->route('receivable.index')->with([
                'status_succeed' => trans('message.update_receivable_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function addFormExtend(Request $request)
    {
        if ($request->ajax()) {
            $service_ids = $request->list_services;
            $html = [];

            // $services = Service::select('id', 'name')->whereIn('id', $service_ids)->get();
            $services = CustomerService::select(
                'services.id',
                'services.name',
                'customer_service.id as customer_service_id',
                'customer_service.ended_at as ended_at',
            )
                ->leftjoin('services', 'services.id', 'customer_service.service_id')
                ->where('customer_service.customer_id', $request->customer_id)
                ->whereIn('customer_service.service_id', $service_ids)
                ->get();
            foreach ($services as $service) {
                $html[] = view('partials.form-receivable-extend', ['service' => $service])->render();
            }

            return response()->json([
                'code' => 200,
                'services' => $services,
                'html' => $html
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new ReceivableExport, 'receivable.xlsx');
    }
}
