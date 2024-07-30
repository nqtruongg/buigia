<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getListOrder();
        return view('order.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $this->orderService->update($request, $id);

            DB::commit();

            return response()->json([
                'updated' => true,
                'message' => 'Trạng thái đơn hàng đã được cập nhật.'
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }
}
