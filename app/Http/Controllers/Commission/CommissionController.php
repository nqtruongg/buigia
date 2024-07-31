<?php

namespace App\Http\Controllers\Commission;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommissionRequest;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionController extends Controller
{
    private $commissionService;
    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $commissions = $this->commissionService->getListCommission($request);
        return view('commission.config.index', compact('commissions'));
    }

    public function listCommissionBonus(Request $request)
    {
        $commissionBonus = $this->commissionService->getListCommissionBonus($request);
        return view('commission.list-commission', compact('commissionBonus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commission.config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommissionRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->commissionService->createCommission($request);
            DB::commit();
            return redirect()->route('commission.index')->with([
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
        $commission = $this->commissionService->getCommissionById($id);
        return view('commission.config.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommissionRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->commissionService->updateCommission($request, $id);
            DB::commit();
            return redirect()->route('commission.index')->with([
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
            $this->commissionService->deleteCommission($id);
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
