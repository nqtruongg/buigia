<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerDialog;
use App\Models\CustomerDocument;
use App\Models\CustomerService;
use App\Models\CustomerStatus;
use App\Models\DetailPriceQuote;
use App\Models\PriceQuote;
use App\Models\Receipt;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReceiptRepository
{
    const PAGINATE = 15;
    const OUTSIDE = 4;

    public function getListReceipt($request)
    {
        $datas = Receipt::select(
            'receipts.id',
            'receipts.customer_id',
            'receipts.price',
            'receipts.reason',
            'receipts.date',
            'receipts.type',
            'customers.name as customer_name',
            'customers.address as customer_address',
            'customers.code as customer_code',
        )
        ->leftjoin('customers', 'customers.id', 'receipts.customer_id');

        if($request->customer_name != null){
            $datas = $datas->where('customers.name', 'LIKE', "%{$request->customer_name}%");
        }
        if($request->code != null){
            $datas = $datas->where('customers.code', 'LIKE', "%{$request->code}%");
        }
        if ($request->from != null) {
            $datas = $datas->whereDate('receipts.date', '>=', Carbon::createFromFormat('d/m/Y', $request->from));
        }

        if ($request->to != null) {
            $datas = $datas->whereDate('receipts.date', '<=', Carbon::createFromFormat('d/m/Y', $request->to));
        }

        $datas = $datas->paginate(self::PAGINATE);

        return $datas;
    }

    public function getReceiptById($id)
    {
        $data = Receipt::select(
            'receipts.id',
            'receipts.price',
            'receipts.reason',
            'receipts.date',
            'receipts.receivable_id',
            'customers.address as address',
            'customers.name as name',
            'customers.id as customer_id',
        )
        ->leftjoin('customers', 'customers.id', 'receipts.customer_id')
        ->where('receipts.id', $id)
        ->first();
        
        return $data;
    }

    public function getListCustomer()
    {
        $customers = Customer::select('id', 'name')->get();
        return $customers;
    }

    public function createReceipt($request)
    {
        $params = [
            'customer_id' => $request->customer,
            'price' => $request->price,
            'reason' => $request->reason,
            'address' => $request->address,
            'date' => Carbon::now(),
            'type' => self::OUTSIDE
        ];
        Receipt::create($params);
        return true;
    }

    public function updateReceipt($request, $id)
    {
        $data = Receipt::find($id);
        if($data){
            $params = [
                'customer_id' => $request->customer,
                'price' => $request->price,
                'reason' => $request->reason,
                'address' => $request->address,
                'type' => self::OUTSIDE
            ];
            $data->update($params);
            return true;
        }
        return false;
    }
}
