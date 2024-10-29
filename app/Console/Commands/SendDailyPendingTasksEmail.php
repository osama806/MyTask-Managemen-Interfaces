<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendEmail;

class SendDailyPendingTasksEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-daily-pending-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users with their pending tasks for the day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $users = User::all();

         foreach ($users as $user) {
             $pendingTasks = Task::where('created_by', $user->id)
                 ->where('status', 'Pending')
                 ->get();

             if ($pendingTasks->isNotEmpty()) {
                 Mail::to($user->email)->queue(new SendEmail($user, $pendingTasks));
             }
         }

         $this->info('Daily pending tasks email sent successfully.');
    }
}
