<?php

namespace App\Exports;

use App\Models\Receivable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ReceivableExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return Receivable::query()->with(['customer', 'service', 'user'])->select('customer_id', 'service_id', 'user_id', 'customer_service_id', 'contract_value' , 'amount_owed', 'advance_date_1', 'advance_value_1', 'reason_1', 'advance_date_2', 'advance_value_2', 'reason_2', 'advance_date_3', 'advance_value_3', 'reason_3', 'created_at');
        } else {
            return Receivable::query()->with(['customer', 'service', 'user'])
                ->where('user_id', $user->id)
                ->select('customer_id', 'service_id', 'user_id', 'customer_service_id', 'contract_value' , 'amount_owed', 'advance_date_1', 'advance_value_1', 'reason_1', 'advance_date_2', 'advance_value_2', 'reason_2', 'advance_date_3', 'advance_value_3', 'reason_3', 'created_at');
        }
    }

        /**
    * @param \App\Models\Receivable $recievable
    * @return array
    */
    public function map($recievable): array
    {
        return [
            $recievable->customer ? $recievable->customer->name : '',
            $recievable->service ? $recievable->service->name : '',
            $recievable->user ? $recievable->user->first_name . ' ' . $recievable->user->last_name  : '',
            $recievable->customer_service_id,
            $recievable->contract_value,
            $recievable->amount_owed,
            $recievable->advance_date_1 ? Carbon::parse($recievable->advance_date_1)->format('d/m/Y') : '',
            $recievable->advance_value_1,
            $recievable->reason_1,
            $recievable->advance_date_2 ? Carbon::parse($recievable->advance_date_2)->format('d/m/Y') : '',
            $recievable->advance_value_2,
            $recievable->reason_2,
            $recievable->advance_date_3 ? Carbon::parse($recievable->advance_date_3)->format('d/m/Y') : '',
            $recievable->advance_value_3,
            $recievable->reason_3,
            $recievable->created_at ? Carbon::parse($recievable->created_at)->format('d/m/Y') : '',
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Tên dịch vụ',
            'Nhân viên phụ trách',
            'ID Đơn',
            'Tổng tiền hợp đồng',
            'Số tiền còn nợ',
            'Ngày ứng tiền lần 1',
            'Tiền ứng lần 1',
            'Lý do ứng lần 1',
            'Ngày ứng tiền lần 2',
            'Tiền ứng lần 2',
            'Lý do ứng lần 2',
            'Ngày ứng tiền lần 3',
            'Tiền ứng lần 3',
            'Lý do ứng lần 3',
            'Ngày tạo',
        ];
    }
}
