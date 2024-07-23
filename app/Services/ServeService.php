<?php

namespace App\Services;

use App\Repositories\ServiceRepository;

class ServeService
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getListService($request)
    {
        return $this->serviceRepository->getListService($request);
    }

    public function createService($request)
    {
        return $this->serviceRepository->createService($request);
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->getServiceById($id);
    }

    public function updateService($request, $id)
    {
        return $this->serviceRepository->updateService($request, $id);
    }
}
