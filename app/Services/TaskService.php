<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class TaskService
{
    const PAGINATE = 10;
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $tasks = Task::select(
            'project_tasks.id',
            'project_tasks.title',
            'project_tasks.project_id',
            'project_tasks.user_id',
            'project_tasks.description',
            'project_tasks.status',
            'project_tasks.type',
            'project_tasks.started_at',
            'project_tasks.ended_at',
            'project_tasks.percent',
            'project_tasks.estimate_time',
            'task_status.name as name_status',
            'task_types.name as name_type',
            'users.name as user_name',
            'projects.name as project_name'
        )
        ->leftjoin('users', 'users.id', 'project_tasks.user_id')
        ->leftjoin('task_status', 'task_status.id', 'project_tasks.status')
        ->leftjoin('task_types', 'task_types.id', 'project_tasks.type')
        ->leftjoin('projects', 'projects.id', 'project_tasks.project_id')
        ->orderBy('project_tasks.id', 'DESC')
        ->paginate(self::PAGINATE);

        return $tasks;
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();

            $params = [
                'title' => $request['name'],
                'project_id' => $request['project_id'],
                'user_id' => $request['user_id'],
                'description' => $request['description'],
                'status' => $request['status'],
                'type' => $request['type'],
                'started_at' => isset($request['started_at']) ? Carbon::createFromFormat('d/m/Y', $request['started_at']) : $request['started_at'],
                'ended_at' => isset($request['ended_at']) ? Carbon::createFromFormat('d/m/Y', $request['ended_at']) : $request['ended_at'],
                'estimate_time' => $request['estimate_time'],
                'percent' => $request['percent'],
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ];

            Task::create($params);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return false;
        }
    }

    public function update($id, $request)
    {
        $task = Task::find($id);

        try {
            DB::beginTransaction();

            $params = [
                'title' => $request['name'],
                'project_id' => $request['project_id'],
                'user_id' => $request['user_id'],
                'description' => $request['description'],
                'status' => $request['status'],
                'type' => $request['type'],
                'started_at' => isset($request['started_at']) ? Carbon::createFromFormat('d/m/Y', $request['started_at']) : $request['started_at'],
                'ended_at' => isset($request['ended_at']) ? Carbon::createFromFormat('d/m/Y', $request['ended_at']) : $request['ended_at'],
                'estimate_time' => $request['estimate_time'],
                'percent' => $request['percent'],
                'updated_by' => Auth::id(),
            ];

            $task->update($params);

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return false;
        }
    }
}
