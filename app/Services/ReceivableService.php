<?php

namespace App\Services;

use App\Repositories\ReceivableRepository;

class ReceivableService
{
    private $receivableRepository;

    public function __construct(ReceivableRepository $receivableRepository)
    {
        $this->receivableRepository = $receivableRepository;
    }

    public function getListReceivable($request)
    {
        return $this->receivableRepository->getListReceivable($request);
    }

    public function getListCustomer()
    {
        return $this->receivableRepository->getListCustomer();
    }

    public function createReceivable($request)
    {
        return $this->receivableRepository->createReceivable($request);
    }

    public function updateReceivable($request, $id)
    {
        return $this->receivableRepository->updateReceivable($request, $id);
    }
    
    public function getReceivableById($id)
    {
        return $this->receivableRepository->getReceivableById($id);
    }

    public function getServiceByCustomer($customer_id)
    {
        return $this->receivableRepository->getServiceByCustomer($customer_id);
    }

    public function createReceivableExtend($request)
    {
        return $this->receivableRepository->createReceivableExtend($request);
    }

    public function updateReceivableExtend($request, $id)
    {
        return $this->receivableRepository->updateReceivableExtend($request, $id);
    }
}
