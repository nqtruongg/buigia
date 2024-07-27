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

    public function getAllArea()
    {
        return $this->serviceRepository->getAllArea();
    }

    public function getListCategoryService()
    {
        return $this->serviceRepository->getListCategoryService();
    }

    public function getListHouseHolder()
    {
        return $this->serviceRepository->getListHouseHolder();
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

    public function delete($id)
    {
        return $this->serviceRepository->delete($id);
    }

    public function destroyImage($id)
    {
        return $this->serviceRepository->destroyImage($id);
    }
}
