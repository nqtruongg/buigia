<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getListPost()
    {
        return $this->postRepository->getListPost();
    }

    public function getListCategoryPost()
    {
        return $this->postRepository->getListCategoryPost();
    }

    public function getPostById($id)
    {
        return $this->postRepository->getPostById($id);
    }

    public function createPost($request)
    {
        return $this->postRepository->createPost($request);
    }

    public function updatePost($request, $id)
    {
        return $this->postRepository->updatePost($request, $id);
    }

    public function deletePost($id)
    {
        return $this->postRepository->deletePost($id);
    }
}
