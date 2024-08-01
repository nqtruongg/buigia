<?php

namespace App\Http\Controllers\Receivable;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $datas = $this->paymentService->getListPayment($request);
        return view('payment.index', compact('datas'));
    }

    public function create()
    {
        $customers = $this->paymentService->getListCustomer();
        return view('payment.create', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->paymentService->createPayment($request);
            DB::commit();
            return redirect()->route('payment.index')->with([
                'status_succeed' => trans('message.create_payment_success')
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
        $data = $this->paymentService->getPaymentById($id);

        $date = Carbon::createFromFormat('Y-m-d', $data->date);

        $formattedDate = "Ngày " . $date->day . " tháng " . $date->month . " năm " . $date->year;

        $customers = $this->paymentService->getListCustomer();

        return view('payment.edit', compact('data', 'formattedDate', 'customers'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->paymentService->updatePayment($request, $id);
            DB::commit();
            return redirect()->route('payment.index')->with([
                'status_succeed' => trans('message.update_payment_success')
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
            Payment::where('id',$id)->delete();
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

    public function printf($id)
    {
        $data = $this->paymentService->getPaymentById($id);
        $date = Carbon::createFromFormat('Y-m-d', $data->date);
        $formattedDate = "Ngày " . $date->day . " tháng " . $date->month . " năm " . $date->year;
        return view('payment.printf', compact('data', 'formattedDate'));
    }
}
