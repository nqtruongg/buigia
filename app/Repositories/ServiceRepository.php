<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    const PAGINATE = 15;

    public function getListService($request)
    {
        $services = Service::select('id', 'name', 'price', 'description', 'type');

        if($request->name != null){
            $services = $services->where('name', 'LIKE', "%{$request->name}%");
        }

        $services = $services->paginate(self::PAGINATE);
        return $services;
    }

    public function createService($request)
    {
        Service::create([
            'name' => $request->name,
            'price' => str_replace(',', '', $request->price),
            'type' => $request->type,
            'description' => $request->description
        ]);
        return true;
    }

    public function getServiceById($id)
    {
        $service = Service::find($id);
        return $service;
    }

    public function updateService($request, $id)
    {
        $service = Service::find($id);
        $service->update([
            'name' => $request->name,
            'price' => str_replace(',', '', $request->price),
            'description' => $request->description,
            'type' => $request->type,
        ]);
        return true;
    }
}
