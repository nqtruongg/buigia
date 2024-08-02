<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
    const PAGINATE = 15;

    public function getListRole($request)
    {
        $roles = Role::select(
            'roles.id',
            'roles.department_id',
            'roles.name',
            'departments.name as department_name',
            DB::raw("GROUP_CONCAT(permissions.description SEPARATOR ', ') as permissions")
        );

        if ($request->name != null) {
            $roles = $roles->where('roles.name', 'LIKE', "%{$request->name}%");
        }

        if($request->department_id != null){
            $roles = $roles->where('roles.department_id', $request->department_id);
        }

        $roles = $roles->leftJoin('departments', 'departments.id', '=', 'roles.department_id')
        ->leftJoin('role_has_permission', 'role_has_permission.role_id', '=', 'roles.id')
        ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permission.permission_id')
        ->groupBy('roles.id', 'roles.department_id', 'roles.name', 'departments.name')
        ->orderBy('roles.id', 'desc')
        ->paginate(self::PAGINATE);
        return $roles;
    }

    public function createRole($request)
    {
        $role = Role::create([
            'department_id' => $request->department_id,
            'name' => $request->name
        ]);

        if (isset($request->permission_id)) {
            $params = [];
            foreach ($request->permission_id as $item) {
                $data = [
                    'role_id' => $role->id,
                    'permission_id' => $item
                ];
                $params[] = $data;
            }
            RoleHasPermission::insert($params);
        }

        return true;
    }

    public function getDepartment()
    {
        $departments = Department::select('id', 'name')->get();
        return $departments;
    }

    public function getPermission()
    {
        $permissions = Permission::select('id', 'type')->get();
        return $permissions;
    }

    public function getRoleById($id)
    {
        $role = Role::find($id);
        return $role;
    }

    public function updateRole($request,$id)
    {
        $role = Role::find($id);
        if($role){
            $role->update([
                'department_id' => $request->department_id,
                'name' => $request->name
            ]);
            RoleHasPermission::where('role_id', $id)->delete();

            if (isset($request->permission_id)) {
                $params = [];
                foreach ($request->permission_id as $item) {
                    $data = [
                        'role_id' => $role->id,
                        'permission_id' => $item
                    ];
                    $params[] = $data;
                }
                RoleHasPermission::insert($params);
            }

            return true;
        }
        return false;
    }
}
