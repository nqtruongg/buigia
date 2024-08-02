<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\CommissionBonus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommissionBonusExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return CommissionBonus::query()->with(['user', 'customerService'])->select('user_id', 'customer_service_id', 'price', 'reason', 'date');
        } else {
            return CommissionBonus::query()->with(['user', 'customerService'])
                ->where('user_id', $user->id)
                ->select('user_id', 'customer_service_id', 'price', 'reason', 'date');
        }
    }

        /**
    * @param \App\Models\CommissionBonus $commissionBonus
    * @return array
    */
    public function map($commissionBonus): array
    {
        return [
            $commissionBonus->user ? $commissionBonus->user->first_name : '',
            $commissionBonus->user ? $commissionBonus->user->last_name : '',
            $commissionBonus->customerService->service ? $commissionBonus->customerService->service->name : '',
            $commissionBonus->price,
            $commissionBonus->reason,
            $commissionBonus->date ? Carbon::parse($commissionBonus->date)->format('d/m/Y') : '',
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Họ',
            'Tên',
            'Tên dịch vụ',
            'Số tiền',
            'Lý do',
            'Ngày khách chuyển tiền',
        ];
    }
}
