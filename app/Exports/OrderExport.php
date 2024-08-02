<?php

namespace App\Exports;

use App\Models\CustomerService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return CustomerService::query()->with(['customer', 'service'])->select('customer_id', 'service_id', 'subtotal', 'started_at', 'ended_at', 'note' , 'type', 'contract_date');
        } else {
            return CustomerService::query()->with(['customer', 'service'])
                ->where('user_id', $user->id)
                ->select('customer_id', 'service_id', 'subtotal', 'started_at', 'ended_at', 'note' , 'type', 'contract_date');
        }
    }

        /**
    * @param \App\Models\CustomerService $order
    * @return array
    */
    public function map($order): array
    {
                // Định dạng giá trị của type
                $type = '';
                switch ($order->type) {
                    case 1:
                        $type = 'Giữ chỗ';
                        break;
                    case 2:
                        $type = 'Đã cọc';
                        break;
                    case 3:
                        $type = 'Đã thuê';
                        break;
                    case 4:
                        $type = 'Đã hủy';
                        break;
                    default:
                        $type = 'Không xác định';
                }


        return [
            $order->customer ? $order->customer->name : '',
            $order->service ? $order->service->name : '',
            $order->subtotal,
            $order->started_at ? Carbon::parse($order->started_at)->format('d/m/Y') : '',
            $order->ended_at ? Carbon::parse($order->ended_at)->format('d/m/Y') : '',
            $order->note,
            $type,
            $order->contract_date ? Carbon::parse($order->contract_date)->format('d/m/Y') : '',
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Họ và tên',
            'Tên dịch vụ',
            'Giá tiền',
            'Ngày bắt đầu',
            'Ngày kết thúc',
            'Ghi chú',
            'Trạng thái',
            'Ngày tạo đơn',
        ];
    }
}
