<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SupplierRepository
{
    const PAGINATE = 15;

    public function getListSupplier($request)
    {
        $datas = Supplier::select(
            'id',
            'name',
            'tax_code',
            'phone',
            'email',
            'responsible_person'
        );

        if($request->name != null){
            $datas = $datas->where('name', 'LIKE', "%{$request->name}%");
        }

        if($request->responsible_person != null){
            $datas = $datas->where('responsible_person', 'LIKE', "%{$request->responsible_person}%");
        }

        if($request->phone != null){
            $datas = $datas->where('phone', 'LIKE', "%{$request->phone}%");
        }

        if($request->email != null){
            $datas = $datas->where('email', 'LIKE', "%{$request->email}%");
        }

        if($request->tax_code != null){
            $datas = $datas->where('tax_code', 'LIKE', "%{$request->tax_code}%");
        }

        $datas = $datas->orderBy('id', 'desc')->paginate(self::PAGINATE);

        return $datas;
    }

    public function getSupplierById($id)
    {
        $data = Supplier::find($id);
        return $data;
    }

    public function createSupplier($request)
    {
        $params = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'tax_code' => $request->tax_code,
            'address' => $request->address,
            'responsible_person' => $request->responsible_person,
        ];

        Supplier::create($params);

        return true;
    }

    public function updateSupplier($request, $id)
    {
        $data = Supplier::find($id);
        if($data){
            $params = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'tax_code' => $request->tax_code,
                'address' => $request->address,
                'responsible_person' => $request->responsible_person,
            ];
    
            $data->update($params);

            return true;
        }
        
        return false;
    }
}
