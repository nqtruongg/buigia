<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Customer;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\ProjectType;
use App\Services\ProjectService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use App\Events\SendMailDeadline;
use App\Models\ProjectMember;
use App\Models\User;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->index();
        return view('project.index', compact('projects'));
    }

    public function create()
    {
        $types = ProjectType::select('id', 'name')->get();
        $status = ProjectStatus::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        return view('project.create', compact('customers', 'types', 'status', 'users'));
    }

    public function store(ProjectRequest $request)
    {
        try {
            $this->projectService->create($request->all());
            return redirect()->route('project.index')->with([
                'status_succeed' => trans('message.create_project_successd')
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
        $project = Project::find($id);

        $types = ProjectType::select('id', 'name')->get();
        $status = ProjectStatus::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        $members = ProjectMember::where('project_id', $id)->pluck('user_id')->toArray();

        return view('project.edit', compact('customers', 'types', 'status', 'project', 'users', 'members'));
    }

    public function update($id, Request $request)
    {
        
        try {
            $this->projectService->update($id, $request->all());
            return redirect()->route('project.index')->with([
                'status_succeed' => trans('message.update_project_successd')
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' ---Line: ' . $exception->getLine());
            return back()->with([
                'status_failed' => trans('message.server_error')
            ]);
        }
    }
}
