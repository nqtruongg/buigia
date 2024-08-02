<?php

namespace App\Services;

use App\Repositories\SettingRepository;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSetting($request)
    {
        return $this->settingRepository->getAllSetting($request);
    }

    public function getSettingByIdCate($request, $id)
    {
        return $this->settingRepository->getSettingByIdCate($request, $id);
    }

    public function getSettingById($id)
    {
        return $this->settingRepository->getSettingById($id);
    }

    public function createSetting($request)
    {
        return $this->settingRepository->createSetting($request);
    }

    public function updateSetting($request, $id)
    {
        return $this->settingRepository->updateSetting($request, $id);
    }

    public function deleteSetting($id)
    {
        return $this->settingRepository->deleteSetting($id);
    }
}
