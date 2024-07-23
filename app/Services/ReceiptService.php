<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\ReceiptRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class ReceiptService
{
    protected $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepository)
    {
        $this->receiptRepository = $receiptRepository;
    }

    public function getListReceipt($request)
    {
        return $this->receiptRepository->getListReceipt($request);
    }

    public function getReceiptById($id)
    {
        return $this->receiptRepository->getReceiptById($id);
    }

    public function getListCustomer()
    {
        return $this->receiptRepository->getListCustomer();
    }

    public function createReceipt($request)
    {
        return $this->receiptRepository->createReceipt($request);
    }

    public function updateReceipt($request, $id)
    {
        return $this->receiptRepository->updateReceipt($request, $id);
    }
}
