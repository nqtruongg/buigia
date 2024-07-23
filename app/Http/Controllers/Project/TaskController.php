<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->index();
        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::select('id', 'name')->get();
        $task_types = DB::table('task_types')->select('id', 'name')->get();
        $task_status = DB::table('task_status')->select('id', 'name')->get();
        return view('task.create', compact('projects', 'task_types', 'task_status'));
    }

    public function store(TaskRequest $request)
    {
        $data = $this->taskService->create($request->all());
        if ($data) {
            return redirect()->route('task.index')->with([
                'status_succeed' => trans('message.create_task_successd')
            ]);
        }

        return back()->with([
            'status_failed' => trans('message.server_error')
        ]);
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $projects = Project::select('id', 'name')->get();
        $task_types = DB::table('task_types')->select('id', 'name')->get();
        $task_status = DB::table('task_status')->select('id', 'name')->get();
        $members = ProjectMember::select(
            'project_members.user_id',
            'users.name'
        )
            ->leftjoin('users', 'users.id', 'project_members.user_id')
            ->where('project_id', $task->project_id)
            ->get();

        return view('task.edit', compact('task','projects', 'task_types', 'task_status', 'members'));
    }

    public function update($id, TaskRequest $request)
    {
        $data = $this->taskService->update($id, $request->all());
        if ($data) {
            return redirect()->route('task.index')->with([
                'status_succeed' => trans('message.update_task_successd')
            ]);
        }

        return back()->with([
            'status_failed' => trans('message.server_error')
        ]);
    }

    public function getMember(Request $request)
    {
        $members = ProjectMember::select(
            'project_members.user_id',
            'users.name'
        )
            ->leftjoin('users', 'users.id', 'project_members.user_id')
            ->where('project_id', $request->id)
            ->get();

        return response()->json([
            'members' => $members
        ]);
    }
}
