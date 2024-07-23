<?php

namespace App\Http\Controllers\Receivable;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Receipt;
use App\Services\ReceiptService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller
{
    private $receiptService;

    public function __construct(ReceiptService $receiptService)
    {
        $this->receiptService = $receiptService;
    }

    public function index(Request $request)
    {
        $datas = $this->receiptService->getListReceipt($request);
        return view('receipt.index', compact('datas'));
    }

    public function create()
    {
        $customers = $this->receiptService->getListCustomer();
        return view('receipt.create', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->receiptService->createReceipt($request);
            DB::commit();
            return redirect()->route('receipt.index')->with([
                'status_succeed' => trans('message.create_receipt_success')
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
        $data = $this->receiptService->getReceiptById($id);
        $customers = $this->receiptService->getListCustomer();

        $date = Carbon::createFromFormat('Y-m-d', $data->date);

        $formattedDate = "Ngày " . $date->day . " tháng " . $date->month . " năm " . $date->year;

        return view('receipt.edit', compact('data', 'formattedDate', 'customers'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->receiptService->updateReceipt($request, $id);
            DB::commit();
            return redirect()->route('receipt.index')->with([
                'status_succeed' => trans('message.update_receipt_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function getAddress(Request $request)
    {
        if ($request->ajax()) {
            
            $customer = Customer::select('address', 'name')->where('id', $request->customer)->first();
            if($customer){
                return response()->json([
                    'code' => 200,
                    'address' => $customer->address,
                    'name' => $customer->name,
                ]);
            } 
        }
    }

    public function printf($id)
    {
        $data = $this->receiptService->getReceiptById($id);
        $date = Carbon::createFromFormat('Y-m-d', $data->date);
        $formattedDate = "Ngày " . $date->day . " tháng " . $date->month . " năm " . $date->year;
        return view('receipt.printf', compact('data', 'formattedDate'));
    }

    public function delete($id)
    {
        try {

            DB::beginTransaction();
            Receipt::where('id',$id)->delete();
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
}
