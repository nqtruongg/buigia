<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    const PAGINATE = 15;
    public function index(Request $request)
    {
        $departments = Department::select('id', 'name');
        if ($request->search) {
            $departments = $departments->where('name', 'LIKE', "%{$request->search}%");
        }

        $departments = $departments->paginate(self::PAGINATE);
        return view('department.index', compact('departments'));
    }

    public function create()
    {
        return view('department.create');
    }

    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();
            Department::create([
                'name' => $request->name
            ]);
            DB::commit();
            return redirect()->route('department.index')->with([
                'status_succeed' => trans('message.create_departmant_success')
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
        $data = Department::select('id', 'name')->where('id', $id)->first();
        if (!$data) {
            return redirect()->route('department.index')->with([
                'status_failed' => trans('message.not_department')
            ]);
        }
        return view('department.edit', compact('data'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $department = Department::find($id);
            if ($department) {
                $department->update([
                    'name' => $request->name
                ]);
                DB::commit();
                return redirect()->route('department.index')->with([
                    'status_succeed' => trans('message.update_departmant_success')
                ]);
            }

            return redirect()->route('department.index')->with([
                'status_failed' => trans('message.not_department')
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
            $department = Department::find($id);
            if ($department) {
                DB::beginTransaction();
                $department->delete();
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
