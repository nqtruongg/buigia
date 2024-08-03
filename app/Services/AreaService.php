<?php
namespace App\Services;

use App\Repositories\AreaRepository;
class AreaService
{
    private $areaRepository;

    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function getListParentArea()
    {
        return $this->areaRepository->getListParentArea();
    }

    public function getAllCities($request)
    {
        return $this->areaRepository->getAllCities($request);
    }

    public function getAllDistrictByCityId($request, $city_id)
    {
        return $this->areaRepository->getAllDistrictByCityId($request, $city_id);
    }

    public function getAllCommunesByCityId($request, $district_id)
    {
        return $this->areaRepository->getAllCommunesByCityId($request, $district_id);
    }

    public function getAreaByCate($id)
    {
        return $this->areaRepository->getAreaByCate($id);
    }
    public function getListArea($request)
    {
        return $this->areaRepository->getListArea($request);
    }

    public function getAreaById($id)
    {
        return $this->areaRepository->getAreaById($id);
    }

    public function createArea($request)
    {
        return $this->areaRepository->createArea($request);
    }

    public function updateArea($request, $id)
    {
        return $this->areaRepository->updateArea($request, $id);
    }

    public function deleteArea($id)
    {
        return $this->areaRepository->deleteArea($id);
    }
}
