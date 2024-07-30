<?php

namespace App\Repositories;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    const PAGINATE = 15;

    public function getListUser($request)
    {
        $users = User::select(
            'users.id',
            'users.email',
            'users.phone',
            'users.address',
            'departments.name as department_name',
            'roles.name as role_name',
            DB::raw('CONCAT(first_name, " ", last_name) as full_name'),
        )
        ->leftjoin('departments', 'departments.id', 'users.department_id')
        ->leftjoin('roles', 'roles.id', 'users.role_id');

        if ($request->name != null) {
            $fullName = $request->name;
            $users->where(function ($query) use ($fullName) {
                $query->whereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%$fullName%"]);
            });
        }

        if($request->email != null){
            $users = $users->where('users.email', $request->email);
        }

        if($request->phone != null){
            $users = $users->where('users.phone', $request->phone);
        }

        if($request->department_id != null){
            $users = $users->where('users.department_id', $request->department_id);
        }

        if($request->role_id != null){
            $users = $users->where('users.role_id', $request->role_id);
        }

        $users = $users->orderBy('users.id', 'desc')->paginate(self::PAGINATE);

        return $users;
    }

    public function getUserbyId($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function getListDepartment()
    {
        $departments = Department::select('id', 'name')->get();
        return $departments;
    }

    public function getListRole($department_id)
    {
        $roles = Role::select('id', 'name')->where('department_id', $department_id)->get();
        return $roles;
    }

    public function getAllCommissionByPercent()
    {
        $commissions = Commission::select('id', 'percent')
            ->orderBy('id', 'desc')
            ->get();
        return $commissions;
    }

    public function createUser($request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'commission_id' => $request->commission_id,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->attach($request->role_id);
        return true;
    }

    public function updateUser($request, $id)
    {
        $user = User::find($id);
        if($request->password != null){
            $password = Hash::make($request->password);
        }else{
            $password = $user->password;
        }
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'commission_id' => $request->commission_id,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'address' => $request->address,
            'password' => $password,
        ]);

        if ($request->role_id != null) {
            $user->roles()->sync([$request->role_id]);
        }

        return true;
    }

    public function getListRoleAll()
    {
        $roles = Role::select('id', 'name')->get();
        return $roles;
    }
}
