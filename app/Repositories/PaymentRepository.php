<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerDialog;
use App\Models\CustomerDocument;
use App\Models\CustomerService;
use App\Models\CustomerStatus;
use App\Models\DetailPriceQuote;
use App\Models\Payment;
use App\Models\PriceQuote;
use App\Models\Receipt;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentRepository
{
    const PAGINATE = 15;
    const OUTSIDE = 4;

    public function getListPayment($request)
    {
        $datas = Payment::select(
            'id',
            'name',
            'price',
            'reason',
            'date',
        );

        if($request->name != null){
            $datas = $datas->where('name', 'LIKE', "%{$request->name}%");
        }

        if ($request->from != null) {
            $datas = $datas->whereDate('date', '>=', Carbon::createFromFormat('d/m/Y', $request->from));
        }

        if ($request->to != null) {
            $datas = $datas->whereDate('date', '<=', Carbon::createFromFormat('d/m/Y', $request->to));
        }

        $datas = $datas->orderBy('id', 'desc')->paginate(self::PAGINATE);

        return $datas;
    }

    public function getPaymentById($id)
    {
        $data = Payment::select(
            'id',
            'name',
            'price',
            'reason',
            'date',
            'address'
        )
        ->where('id', $id)
        ->first();

        return $data;
    }

    public function getListCustomer()
    {
        $customers = Customer::select('id', 'name')->get();
        return $customers;
    }

    public function createPayment($request)
    {
        $params = [
            'name' => $request->name,
            'user_id' => $request->user_id ?? null,
            'price' => $request->price,
            'reason' => $request->reason,
            'address' => $request->address,
            'date' => Carbon::now(),
        ];
        Payment::create($params);
        return true;
    }


    public function updatePayment($request, $id)
    {
        $data = Payment::find($id);
        if($data){
            $params = [
                'name' => $request->name,
                'user_id' => $request->user_id ?? null,
                'price' => $request->price,
                'reason' => $request->reason,
                'address' => $request->address,
            ];

            $data->update($params);

            return true;
        }
        return false;
    }
}
