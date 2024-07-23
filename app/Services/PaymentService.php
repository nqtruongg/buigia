<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function getListPayment($request)
    {
        return $this->paymentRepository->getListPayment($request);
    }

    public function getPaymentById($id)
    {
        return $this->paymentRepository->getPaymentById($id);
    }

    public function getListCustomer()
    {
        return $this->paymentRepository->getListCustomer();
    }

    public function createPayment($request)
    {
        return $this->paymentRepository->createPayment($request);
    }

    public function updatePayment($request, $id)
    {
        return $this->paymentRepository->updatePayment($request, $id);
    }
}
