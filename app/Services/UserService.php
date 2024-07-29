<?php

namespace App\Services;

use App\Exceptions\SendJsonErrorException;
use App\Repositories\BankRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getListUser($request)
    {
        return $this->userRepository->getListUser($request);
    }

    public function getUserbyId($id)
    {
        return $this->userRepository->getUserbyId($id);
    }

    public function getListDepartment()
    {
        return $this->userRepository->getListDepartment();
    }

    public function getListRole($department_id)
    {
        return $this->userRepository->getListRole($department_id);
    }

    public function updateUser($request, $id)
    {
        return $this->userRepository->updateUser($request, $id);
    }

    public function createUser($request)
    {
        return $this->userRepository->createUser($request);
    }

    public function getListRoleAll()
    {
        return $this->userRepository->getListRoleAll();
    }

    public function getAllCommissionByPercent()
    {
        return $this->userRepository->getAllCommissionByPercent();
    }
}
