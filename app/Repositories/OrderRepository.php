<?php

namespace App\Repositories;

use App\Models\CustomerService;
use App\Models\Service;
use App\Services\OrderService;

class OrderRepository
{
    const PAGINATE = 15;

    const PAGINATE_FILE = 5;

    public function getListOrder($request)
    {
        $orders = CustomerService::with(['service', 'customer']);

        if($request->name != null){
            $orders = $orders->whereHas('customer', function($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->name}%");
            });
        }

        if($request->service_name != null){
            $orders = $orders->whereHas('service', function($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->service_name}%");
            });
        }

        if($request->contract_date != null){
            $orders = $orders->where('contract_date', 'LIKE', "%{$request->contract_date}%");
        }

        if($request->price != null){
            $price = str_replace(',', '', $request->price);
            $orders = $orders->where('subtotal', 'LIKE', "%{$price}%");
        }

        if($request->type != null){
            $orders = $orders->where('type', $request->type);
        }

        if($request->start_date != null){
            $orders = $orders->where('started_at', 'LIKE', "%{$request->start_date}%");
        }

        if($request->end_date != null){
            $orders = $orders->where('ended_at', 'LIKE', "%{$request->end_date}%");
        }

        if(auth()->user()->department->type == 'manager'){
        $orders = $orders->latest('id')->paginate(self::PAGINATE);
        }else{
            $orders = $orders->where('user_id', auth()->user()->id)->latest('id')->paginate(self::PAGINATE);
        }
        return $orders;
    }

    public function update($request, $id)
    {
        $order = CustomerService::findOrFail($id);

        if(!$order) {
            return false;
        }

        $order->type = $request->type;
        $order->save();

        $serviceIds = CustomerService::where('customer_id', $order->customer_id)->pluck('service_id');

        foreach ($serviceIds as $serviceId) {
            $customerServiceType = CustomerService::where('customer_id', $order->customer_id)
                ->where('service_id', $serviceId)
                ->pluck('type')
                ->first();
            if ($customerServiceType == 4) {
                Service::where('id', $serviceId)->update(['type' => 0]);
            } else {
                Service::where('id', $serviceId)->update(['type' => $customerServiceType]);
            }

        }
        return true;
    }
}
