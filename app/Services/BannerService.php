<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use App\Repositories\BannerRepository;


class BannerService
{
    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;

    }

    public function getListBannerIndex($request)
    {
        return $this->bannerRepository->getListBannerIndex($request);
    }

    public function getBannerById($id)
    {
        return $this->bannerRepository->getBannerById($id);
    }

    public function getBannerByIdCate($id)
    {
        return $this->bannerRepository->getBannerByIdCate($id);
    }

    public function getAllParentCate()
    {
        return $this->bannerRepository->getAllParentCate();
    }

    public function createBanner($request)
    {
        return $this->bannerRepository->createBanner($request);
    }

    public function updateBanner($request, $id)
    {
        return $this->bannerRepository->updateBanner($request, $id);
    }

    public function deleteBanner($id)
    {
        return $this->bannerRepository->deleteBanner($id);
    }
}
