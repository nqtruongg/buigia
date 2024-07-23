<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getListSupplier($request)
    {
        return $this->supplierRepository->getListSupplier($request);
    }
    
    public function createSupplier($request)
    {
        return $this->supplierRepository->createSupplier($request);
    }

    public function getSupplierById($id)
    {
        return $this->supplierRepository->getSupplierById($id);
    }

    public function updateSupplier($request, $id)
    {
        return $this->supplierRepository->updateSupplier($request, $id);
    }
}