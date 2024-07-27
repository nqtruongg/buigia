<?php
namespace App\Services;

use App\Repositories\FilterRepository;

class FilterService
{
    private $filterRepository;

    public function __construct(FilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    public function getListFilter($request)
    {
        return $this->filterRepository->getListFilter($request);
    }

    public function getListFilterType()
    {
        return $this->filterRepository->getListFilterType();
    }

    public function getFilterById($id)
    {
        return $this->filterRepository->getFilterById($id);
    }

    public function createFilter($request)
    {
        return $this->filterRepository->createFilter($request);
    }

    public function updateFilter($request, $id)
    {
        return $this->filterRepository->updateFilter($request, $id);
    }

    public function deleteFilter($id)
    {
        return $this->filterRepository->deleteFilter($id);
    }
}
