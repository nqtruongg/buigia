<?php

namespace App\Jobs;

use App\Events\SendMailDeadline;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class CheckProjectDeadlines implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $projectDeadlines  = Project::select(
            'projects.id',
            'projects.reply_date',
            'projects.created_by',
            'projects.name',
        )
        ->whereDate('projects.reply_date', '=', $tomorrow)
        ->get();

        if(!empty($projectDeadlines)){
            foreach($projectDeadlines as $item){
                $user = User::find($item->created_by);
                Event::dispatch(new SendMailDeadline($user));
            }
        }
    }
}
