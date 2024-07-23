<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getListUser($request);
        $departments = $this->userService->getListDepartment();
        $roles = $this->userService->getListRoleAll();
        return view('user.index', compact('users', 'departments', 'roles'));
    }

    public function create()
    {
        $departments = $this->userService->getListDepartment();
        return view('user.create', compact('departments'));
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userService->createUser($request);
            DB::commit();
            return redirect()->route('user.index')->with([
                'status_succeed' => trans('message.create_user_success')
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
        $user = $this->userService->getUserbyId($id);
        $departments = $this->userService->getListDepartment();
        return view('user.edit', compact('user', 'departments'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->userService->updateUser($request, $id);
            DB::commit();
            return redirect()->route('user.index')->with([
                'status_succeed' => trans('message.update_user_success')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }

    public function getListRole(Request $request)
    {
        if ($request->ajax()) {
            $department_id = $request->department_id;
            $roles = $this->userService->getListRole($department_id);
            return response()->json([
                'code' => 200,
                'roles' => $roles
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                DB::beginTransaction();
                $user->delete();
                DB::commit();
                return [
                    'status' => 200,
                    'msg' => [
                        'text' => trans('message.success'),
                    ],
                ];
            }
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
