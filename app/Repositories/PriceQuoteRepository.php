<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerDialog;
use App\Models\CustomerDocument;
use App\Models\CustomerService;
use App\Models\CustomerStatus;
use App\Models\DetailPriceQuote;
use App\Models\PriceQuote;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PriceQuoteRepository
{
    const PAGINATE = 15;

    public function getListPriceQuote($request)
    {
        $datas = PriceQuote::select(
            'price_quotes.id',
            'price_quotes.name',
            'price_quotes.status',
            'customers.id as customer_id',
            'customers.name as customer_name',
            'customers.code as customer_code',
            DB::raw('SUM(detail_price_quotes.price) as total_price')
        )
            ->leftJoin('detail_price_quotes', 'detail_price_quotes.price_quote_id', 'price_quotes.id')
            ->leftJoin('customers', 'customers.id', 'price_quotes.customer_id')
            ->whereNull('detail_price_quotes.deleted_at')
            ->groupBy('price_quotes.id', 'price_quotes.name', 'customers.name', 'customers.code', 'customers.id','price_quotes.status');

        if ($request->name != null) {
            $datas = $datas->where('price_quotes.name', 'LIKE', "%{$request->name}%");
        }

        if ($request->customer_name != null) {
            $datas = $datas->where('customers.name', 'LIKE', "%{$request->customer_name}%");
        }

        if ($request->customer_code != null) {
            $datas = $datas->where('customers.code', 'LIKE', "%{$request->customer_code}%");
        }

        $datas = $datas->orderBy('price_quotes.id', 'desc')->paginate(self::PAGINATE);

        return $datas;
    }

    public function getPriceQuoteById($id)
    {
        $data = PriceQuote::select(
            'price_quotes.id',
            'price_quotes.customer_id',
            'price_quotes.name',
            'price_quotes.content',
            'customers.name as customer_name'
        )
            ->leftjoin('customers', 'customers.id', 'price_quotes.customer_id')
            ->where('price_quotes.id', $id)
            ->first();

        return $data;
    }

    public function getServiceByData($id)
    {
        $datas = DetailPriceQuote::where('price_quote_id', $id)->get();
        return $datas;
    }

    public function getListService()
    {
        $services = Service::select('id', 'name')->get();
        return $services;
    }

    public function getListCustomer()
    {
        $customers = Customer::select('id', 'name', 'code')->get();
        return $customers;
    }

    public function createPriceQuote($request)
    {
        $priceQuote = PriceQuote::create([
            'customer_id' => $request->customer,
            'name' => $request->name,
            'content' => $request->content,
            'status' => 0
        ]);

        $services = $request->services;

        foreach ($services as $key => $item) {
            DetailPriceQuote::create([
                'price_quote_id' => $priceQuote->id,
                'service_id' => $item,
                'price' => str_replace(',', '', $request->subtotal[$key]),
                'note' => $request->note[$key],
                'describe' => $request->describe[$key],
            ]);
        }

        return true;
    }

    public function updatePriceQuote($request, $id)
    {
        $priceQuote = PriceQuote::find($id);

        if ($priceQuote) {
            $priceQuote->update([
                'customer_id' => $request->customer,
                'name' => $request->name,
                'content' => $request->content,
                'status' => 0
            ]);
            DetailPriceQuote::where('price_quote_id', $id)->delete();
            $services = $request->services;

            foreach ($services as $key => $item) {
                DetailPriceQuote::create([
                    'price_quote_id' => $priceQuote->id,
                    'service_id' => $item,
                    'price' => str_replace(',', '', $request->subtotal[$key]),
                    'note' => $request->note[$key],
                    'describe' => $request->describe[$key],
                ]);
            }

            return true;
        }
        return false;
    }

    public function getListServiceDetail($id)
    {
        $data = DetailPriceQuote::select(
            'detail_price_quotes.id',
            'detail_price_quotes.price',
            'detail_price_quotes.note',
            'detail_price_quotes.describe',
            'services.name as name'
        )
            ->leftjoin('services', 'services.id', 'detail_price_quotes.service_id')
            ->where('detail_price_quotes.price_quote_id', $id)
            ->get();

        return $data;
    }
}
