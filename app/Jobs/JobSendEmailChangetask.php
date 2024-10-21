<?php

namespace App\Jobs;

use App\Mail\sendEmailChangeTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobSendEmailChangetask implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $userId, private $taskId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        $Task = Task::find($this->taskId);

        Mail::to($user->email)
        ->later(now()->addMinutes(1), new sendEmailChangeTask($user, $Task));
    }
}
