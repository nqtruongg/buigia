<?php

namespace App\Exports;

use App\Models\Receipt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReceiptExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return Receipt::query()->with(['customer', 'user'])->select('customer_id', 'price', 'reason', 'date');
        } else {
            return Receipt::query()->with(['customer', 'user'])
                ->where('user_id', $user->id)
                ->select('customer_id', 'price', 'reason', 'date');
        }
    }

        /**
    * @param \App\Models\Receipt $receipt
    * @return array
    */
    public function map($receipt): array
    {
        return [
            $receipt->customer ? $receipt->customer->name : '',
            $receipt->customer ? $receipt->customer->code : '',
            $receipt->price,
            $receipt->reason,
            $receipt->date ? Carbon::parse($receipt->date)->format('d/m/Y') : '',
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Mã khách hàng',
            'Số tiền',
            'Lý do chuyển tiền',
            'Ngày chuyển tiền',
        ];
    }
}
