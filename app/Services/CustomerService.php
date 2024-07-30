<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getListCustomerIndex($request)
    {
        return $this->customerRepository->getListCustomerIndex($request);
    }

    public function createCustomer($request)
    {
        return $this->customerRepository->createCustomer($request);
    }

    public function updateCustomer($request, $id)
    {
        return $this->customerRepository->updateCustomer($request, $id);
    }

    public function getCustomerStatus()
    {
        return $this->customerRepository->getCustomerStatus();
    }
    public function getStaff(){
        return $this->customerRepository->getStaff();
    }

    public function getListService($id)
    {
        return $this->customerRepository->getListService($id);
    }

    public function getListServiceByType0()
    {
        return $this->customerRepository->getListServiceByType0();
    }

    public function getListSupplier()
    {
        return $this->customerRepository->getListSupplier();
    }

    public function getPriceService($id_service)
    {
        return $this->customerRepository->getPriceService($id_service);
    }

    public function getFileCustomer($request, $id)
    {
        return $this->customerRepository->getFileCustomer($request, $id);
    }

    public function getDetailService($id)
    {
        return $this->customerRepository->getDetailService($id);
    }

    public function getFileCustomerEdit($id)
    {
        return $this->customerRepository->getFileCustomerEdit($id);
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->getCustomerById($id);
    }

    public function getListServiceSave($id)
    {
        return $this->customerRepository->getListServiceSave($id);
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->deleteCustomer($id);
    }

    public function getCustomerDetail($id)
    {
        return $this->customerRepository->getCustomerDetail($id);
    }

    public function getCustomerDialog($request,$id)
    {
        return $this->customerRepository->getCustomerDialog($request,$id);
    }

    public function createCustomerDialog($request, $id)
    {
        return $this->customerRepository->createCustomerDialog($request,$id);
    }

    public function updateCustomerDialog($request, $id)
    {
        return $this->customerRepository->updateCustomerDialog($request,$id);
    }

    public function deleteCustomerDialog($id)
    {
        return $this->customerRepository->deleteCustomerDialog($id);
    }

    public function updateService($request, $id)
    {
        return $this->customerRepository->updateService($request,$id);
    }

    public function createFileDetail($request, $id)
    {
        return $this->customerRepository->createFileDetail($request,$id);
    }
}
