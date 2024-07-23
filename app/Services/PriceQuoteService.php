<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Repositories\PriceQuoteRepository;

class PriceQuoteService
{
    protected $priceQuoteRepository;

    public function __construct(PriceQuoteRepository $priceQuoteRepository)
    {
        $this->priceQuoteRepository = $priceQuoteRepository;
    }

    public function getListPriceQuote($request)
    {
        return $this->priceQuoteRepository->getListPriceQuote($request);
    }

    public function getListService()
    {
        return $this->priceQuoteRepository->getListService();
    }

    public function getListCustomer()
    {
        return $this->priceQuoteRepository->getListCustomer();
    }

    public function createPriceQuote($request)
    {
        return $this->priceQuoteRepository->createPriceQuote($request);
    }

    public function getPriceQuoteById($id)
    {
        return $this->priceQuoteRepository->getPriceQuoteById($id);
    }

    public function getListServiceDetail($id)
    {
        return $this->priceQuoteRepository->getListServiceDetail($id);
    }

    public function getServiceByData($id)
    {
        return $this->priceQuoteRepository->getServiceByData($id);
    }

    public function updatePriceQuote($request, $id)
    {
        return $this->priceQuoteRepository->updatePriceQuote($request, $id);
    }
}
