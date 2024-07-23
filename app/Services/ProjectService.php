<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class ProjectService
{
    const PAGINATE = 10;
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function index()
    {
        $projects = Project::select(
            'projects.id',
            'projects.customer_id',
            'projects.status',
            'projects.type',
            'projects.name',
            'projects.price',
            'projects.discount',
            'projects.started_date',
            'projects.ended_date',
            'projects.price',
            'customers.name as customer_name',
            'project_status.name as status_name',
            'project_type.name as type_name'
        )
            ->leftjoin('customers', 'customers.id', 'projects.customer_id')
            ->leftjoin('project_type', 'project_type.id', 'projects.type')
            ->leftjoin('project_status', 'project_status.id', 'projects.status')
            ->orderBy('projects.id', 'desc')
            ->paginate(self::PAGINATE);

        return $projects;
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();

            $params = [
                'name' => $request['name'],
                'customer_id' => $request['customer_id'],
                'type' => $request['type'],
                'status' => $request['status'],
                'started_date' => isset($request['received_date']) ? Carbon::createFromFormat('d/m/Y', $request['received_date']) : $request['received_date'],
                'ended_date' => isset($request['reply_date']) ? Carbon::createFromFormat('d/m/Y', $request['reply_date']) : $request['reply_date'],
                'price' => $request['price'],
                'discount' => $request['discount'] ?? null,
                'note' => $request['note'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ];

            $project = Project::create($params);

            $data = [];
            if (isset($request['member'])) {
                $members = $request['member'];
                foreach ($members as $member) {
                    $data[] = [
                        'project_id' => $project->id, 
                        'user_id' => $member
                    ];
                }

                ProjectMember::insert($data);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }

    public function update($id, $request)
    {
        $project = Project::find($id);

        try {
            DB::beginTransaction();

            $params = [
                'name' => $request['name'],
                'customer_id' => $request['customer_id'],
                'type' => $request['type'],
                'status' => $request['status'],
                'started_date' => isset($request['received_date']) ? Carbon::createFromFormat('d/m/Y', $request['received_date']) : $request['received_date'],
                'ended_date' => isset($request['reply_date']) ? Carbon::createFromFormat('d/m/Y', $request['reply_date']) : $request['reply_date'],
                'price' => $request['price'],
                'discount' => $request['discount'] ?? null,
                'note' => $request['note'] ?? null,
                'updated_by' => Auth::id(),
            ];

            $project->update($params);

            $data = [];
            if (isset($request['member'])) {

                ProjectMember::where('project_id', $id)->delete();

                $members = $request['member'];
                foreach ($members as $member) {
                    $data[] = [
                        'project_id' => $project->id, 
                        'user_id' => $member
                    ];
                }

                ProjectMember::insert($data);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
}
