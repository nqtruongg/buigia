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

    public function createCity($request)
    {
        return $this->areaRepository->createCity($request);
    }

    public function createDistrict($request)
    {
        return $this->areaRepository->createDistrict($request);
    }

    public function createCommune($request)
    {
        return $this->areaRepository->createCommune($request);
    }

    public function updateCityById($request, $id)
    {
        return $this->areaRepository->updateCityById($request, $id);
    }

    public function updateDistrictById($request, $cityId, $id)
    {
        return $this->areaRepository->updateDistrictById($request, $cityId, $id);
    }

    public function updateCommuneById($request, $districtId, $id)
    {
        return $this->areaRepository->updateCommuneById($request, $districtId, $id);
    }

    public function getCityById($id)
    {
        return $this->areaRepository->getCityById($id);
    }

    public function getDistrictById($cityId, $id)
    {
        return $this->areaRepository->getDistrictById($cityId, $id);
    }

    public function getCommuneById($districtId, $id)
    {
        return $this->areaRepository->getCommuneById($districtId, $id);
    }

    public function deleteArea($id)
    {
        return $this->areaRepository->deleteArea($id);
    }
}
