<?php
namespace App\Services;
use App\Repositories\FilterTypeRepository;

class FilterTypeService{
    private $filterTypeRepository;

    public function __construct(FilterTypeRepository $filterTypeRepository)
    {
        $this->filterTypeRepository = $filterTypeRepository;
    }

    public function getListFilterType($request)
    {
        return $this->filterTypeRepository->getListFilterType($request);
    }

    public function getFilterTypeById($id)
    {
        return $this->filterTypeRepository->getFilterTypeById($id);
    }

    public function createFilterType($request)
    {
        return $this->filterTypeRepository->createFilterType($request);
    }

    public function updateFilterType($request, $id)
    {
        return $this->filterTypeRepository->updateFilterType($request, $id);
    }

    public function deleteFilterType($id)
    {
        return $this->filterTypeRepository->deleteFilterType($id);
    }
}
