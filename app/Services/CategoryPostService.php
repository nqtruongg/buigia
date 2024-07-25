<?php

namespace App\Services;

use App\Repositories\CategoryPostRepository;

class CategoryPostService
{

    protected $categoryPostRepository;

    public function __construct(CategoryPostRepository $categoryPostRepository)
    {
        $this->categoryPostRepository = $categoryPostRepository;
    }

    public function getListCategoryPost()
    {
        return $this->categoryPostRepository->getListCategoryPost();
    }

    public function getCategoryPostById($id)
    {
        return $this->categoryPostRepository->getCategoryPostById($id);
    }

    public function getCategoryPostByIdCate($id)
    {
        return $this->categoryPostRepository->getCategoryPostByIdCate($id);
    }

    public function createCategoryPost($request)
    {
        return $this->categoryPostRepository->createCategoryPost($request);
    }

    public function updateCategoryPost($request, $id)
    {
        return $this->categoryPostRepository->updateCategoryPost($request, $id);
    }

    public function deleteCategoryPost($id)
    {
        return $this->categoryPostRepository->deleteCategoryPost($id);
    }
}
