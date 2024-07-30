<?php

namespace App\Repositories;

use App\Models\CustomerService;
use App\Models\Service;
use App\Services\OrderService;

class OrderRepository
{
    const PAGINATE = 15;

    const PAGINATE_FILE = 5;

    public function getListOrder()
    {
        $orders = CustomerService::with(['service', 'customer'])
            ->latest('id')
            ->paginate(self::PAGINATE);
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
