<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->getListRole($request);
        $departments = $this->roleService->getDepartment();

        return view('role.index', compact('roles', 'departments'));
    }

    public function create()
    {
        $departments = $this->roleService->getDepartment();
        $permissions = $this->roleService->getPermission();
        return view('role.create', compact('departments', 'permissions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->roleService->createRole($request);
            DB::commit();
            return redirect()->route('role.index')->with([
                'status_succeed' => trans('message.update_role_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function edit($id)
    {
        $departments = $this->roleService->getDepartment();
        $permissions = $this->roleService->getPermission();
        $role = $this->roleService->getRoleById($id);
        $arr_permissions = RoleHasPermission::where('role_id', $id)->pluck('permission_id')->toArray();
        return view('role.edit', compact('departments', 'permissions', 'arr_permissions', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->updateRole($request,$id);
            DB::commit();
            return redirect()->route('role.index')->with([
                'status_succeed' => trans('message.update_role_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function delete($id)
    {
        try {

            DB::beginTransaction();
            RoleHasPermission::where('role_id', $id)->delete();
            Role::where('id',$id)->delete();
            DB::commit();
            return [
                'status' => 200,
                'msg' => [
                    'text' => trans('message.success'),
                ],
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => trans('message.server_error')
            ], 500);
        }
    }
}
