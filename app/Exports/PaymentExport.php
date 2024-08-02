<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return Payment::query()->with(['user'])->select('name', 'price', 'address', 'reason', 'date', 'user_id');
        } else {
            return Payment::query()->with(['user'])
                ->where('user_id', $user->id)
                ->select('name', 'price', 'address', 'reason', 'date', 'user_id');
        }
    }

        /**
    * @param \App\Models\Payment $payment
    * @return array
    */
    public function map($payment): array
    {

        $code = $payment->user ? $payment->user->code : '';
        return [
            $payment->name,
            $code,
            $payment->price,
            $payment->address,
            $payment->reason,
            $payment->date ? Carbon::parse($payment->date)->format('d/m/Y') : '',

        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Tên người nhận',
            'Mã nhân viên',
            'Số tiền',
            'Địa chỉ',
            'Lý do chuyển tiền',
            'Ngày chuyển tiền',
        ];
    }
}
