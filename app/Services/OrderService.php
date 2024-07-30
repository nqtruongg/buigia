<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getListOrder()
    {
        return $this->orderRepository->getListOrder();
    }

    public function update($request, $id)
    {
        return $this->orderRepository->update($request, $id);
    }
}
