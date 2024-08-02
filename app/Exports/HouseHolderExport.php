<?php

namespace App\Exports;

use App\Models\HouseHolder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HouseHolderExport implements FromQuery, WithHeadings, WithMapping
{
        /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        return HouseHolder::query()->select('name', 'code', 'phone', 'email', 'address', 'tax_code');
    }

        /**
    * @param \App\Models\HouseHolder $householder
    * @return array
    */
    public function map($householder): array
    {
        return [
            $householder->name,
            $householder->code,
            $householder->phone,
            $householder->email,
            $householder->address,
            $householder->tax_code,
        ];
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'Họ và tên',
            'Mã chủ nhà',
            'Số điện thoại',
            'Email',
            'Địa chỉ cụ thể',
            'Mã số thuế',
        ];
    }
}
