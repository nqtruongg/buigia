<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\CustomerService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceExpireController extends Controller
{
    const PAGINATE = 15;
    public function expireOneDay()
    {
        $day = Carbon::now()->addDay(1)->startOfDay();
        $datas = $this->query($day);

        return view('service_expire.index', compact('datas'));
    }

    public function expireSevenDay()
    {
        $day = Carbon::now()->addDay(7)->startOfDay();
        $datas = $this->query($day);

        return view('service_expire.index', compact('datas'));
    }

    public function expireThirtyDay()
    {
        $day = Carbon::now()->addDay(30)->startOfDay();
        $datas = $this->query($day);

        return view('service_expire.index', compact('datas'));
    }

    public function query($day)
    {
        $datas = CustomerService::select(
            'customer_service.id',
            'customer_service.ended_at',
            'customer_service.note',
            'customer_service.subtotal',
            'services.name as name',
            'customers.code as code',
            'customers.id as customer_id',
            'customers.name as customer_name',
        )
            ->leftjoin('services', 'services.id', 'customer_service.service_id')
            ->leftjoin('customers', 'customers.id', 'customer_service.customer_id')
            ->whereDate('customer_service.ended_at', $day)
            ->paginate(self::PAGINATE);

        return $datas;
    }
}
