<?php

namespace App\Services;

use App\Repositories\HouseHolderRepository;

class HouseHolderService
{
    private $houseHolderRepository;

    public function __construct(HouseHolderRepository $houseHolderRepository)
    {
        $this->houseHolderRepository = $houseHolderRepository;
    }

    public function getListHouseHolder($request)
    {
        return $this->houseHolderRepository->getListHouseHolder($request);
    }

    public function getHouseHolderById($id)
    {
        return $this->houseHolderRepository->getHouseHolderById($id);
    }

    public function createHouseHolder($request)
    {
        return $this->houseHolderRepository->createHouseHolder($request);
    }

    public function updateHouseHolder($request, $id){
        return $this->houseHolderRepository->updateHouseHolder($request, $id);
    }
}
