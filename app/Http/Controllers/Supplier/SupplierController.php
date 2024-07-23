<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(Request $request)
    {
        $datas = $this->supplierService->getListSupplier($request);
        return view('supplier.index', compact('datas'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(SupplierRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->supplierService->createSupplier($request);
            DB::commit();
            return redirect()->route('supplier.index')->with([
                'status_succeed' => trans('message.create_supplier_success')
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
        $data = $this->supplierService->getSupplierById($id);
        return view('supplier.edit', compact('data'));
    }

    public function update(SupplierRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->supplierService->updateSupplier($request, $id);
            DB::commit();
            return redirect()->route('supplier.index')->with([
                'status_succeed' => trans('message.update_supplier_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }
}
