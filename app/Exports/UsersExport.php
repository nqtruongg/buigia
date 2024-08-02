<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        return User::query()->with(['department', 'role'])->select('first_name', 'last_name', 'email', 'phone', 'address', 'department_id', 'role_id');
    }

        /**
    * @param \App\Models\User $user
    * @return array
    */
    public function map($user): array
    {
        return [
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->phone,
            $user->address,
            $user->department ? $user->department->name : '',
            $user->role ? $user->role->name : '',
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
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Phòng ban',
            'Chức vụ',
        ];
    }
}
