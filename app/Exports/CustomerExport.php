<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        $user = Auth::user();
        if ($user->department->type === 'manager') {
            return Customer::query()->with(['city', 'district', 'commune'])->select('name', 'code', 'phone', 'email', 'address', 'commune_id', 'district_id' , 'city_id', 'invoice_address', 'status', 'active');
        } else {
            return Customer::query()->with(['city', 'district', 'commune'])
                ->where('user_id', $user->id)
                ->select('name', 'code', 'phone', 'email', 'address', 'commune_id', 'district_id' , 'city_id', 'invoice_address', 'status', 'active');
        }
    }

        /**
    * @param \App\Models\Customer $customer
    * @return array
    */
    public function map($customer): array
    {
                // Định dạng giá trị của status
                $status = '';
                switch ($customer->status) {
                    case 1:
                        $status = 'Khách mới';
                        break;
                    case 2:
                        $status = 'Đã tư vấn';
                        break;
                    case 3:
                        $status = 'Chốt hợp đồng';
                        break;
                    case 4:
                        $status = 'Không dùng dịch vụ';
                        break;
                    default:
                        $status = 'Không xác định';
                }


        return [
            $customer->name,
            $customer->code,
            $customer->phone,
            $customer->email,
            $customer->address,
            $customer->commune ? $customer->commune->name : '',
            $customer->district ? $customer->district->name : '',
            $customer->city ? $customer->city->name : '',
            $customer->invoice_address,
            $status,
            $customer->active == 1 ? 'Kích hoạt' : 'Không kích hoạt',
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Họ và tên',
            'Mã khách hàng',
            'Số điện thoại',
            'Email',
            'Địa chỉ cụ thể',
            'Phường/Xã',
            'Quận/Huyện',
            'Tỉnh thành',
            'Địa chỉ xuất hóa đơn',
            'Trạng thái',
            'Trạng thái hoạt động',
        ];
    }
}
