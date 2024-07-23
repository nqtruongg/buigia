<?php

namespace App\Services;

use App\Exceptions\SendJsonErrorException;
use App\Repositories\BankRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getListRole($request)
    {
        return $this->roleRepository->getListRole($request);
    }

    public function createRole($request)
    {
        return $this->roleRepository->createRole($request);
    }

    public function getDepartment()
    {
        return $this->roleRepository->getDepartment();
    }

    public function getPermission()
    {
        return $this->roleRepository->getPermission();
    }

    public function getRoleById($id)
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function updateRole($request,$id)
    {
        return $this->roleRepository->updateRole($request,$id);
    }
}
