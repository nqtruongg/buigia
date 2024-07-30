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

    public function getListOrder($request)
    {
        return $this->orderRepository->getListOrder($request);
    }

    public function update($request, $id)
    {
        return $this->orderRepository->update($request, $id);
    }
}
