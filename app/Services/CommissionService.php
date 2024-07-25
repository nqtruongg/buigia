<?php
namespace App\Services;

use App\Repositories\CommissionRepository;

class CommissionService
{
    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
    }

    public function getListCommission($request)
    {
        return $this->commissionRepository->getListCommission($request);
    }

    public function getCommissionById($id)
    {
        return $this->commissionRepository->getCommissionById($id);
    }

    public function createCommission($request)
    {
        return $this->commissionRepository->createCommission($request);
    }

    public function updateCommission($request, $id){
        return $this->commissionRepository->updateCommission($request, $id);
    }

    public function deleteCommission($id){
        return $this->commissionRepository->deleteCommission($id);
    }
}
