<?php
namespace App\Services;

use App\Repositories\CategoryServiceRepository;
class CategoryServiService {
    private $categoryServiceRepository;

    public function __construct(CategoryServiceRepository $categoryServiceRepository)
    {
        $this->categoryServiceRepository = $categoryServiceRepository;
    }

    public function getListCategoryService($request)
    {
        return $this->categoryServiceRepository->getListCategoryService($request);
    }

    public function getCategoryServiceById($id)
    {
        return $this->categoryServiceRepository->getCategoryServiceById($id);
    }

    public function createCategoryService($request)
    {
        return $this->categoryServiceRepository->createCategoryService($request);
    }

    public function updateCategoryService($request, $id)
    {
        return $this->categoryServiceRepository->updateCategoryService($request, $id);
    }

    public function deleteCategoryService($id)
    {
        return $this->categoryServiceRepository->deleteCategoryService($id);
    }

    public function getListCategoryServiceParent()
    {
        return $this->categoryServiceRepository->getListCategoryServiceParent();
    }

    public function getCategoryServiceByCate($request, $id)
    {
        return $this->categoryServiceRepository->getCategoryServiceByCate($request, $id);
    }
}
