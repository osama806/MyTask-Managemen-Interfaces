<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $pendingTasks;

    public function __construct(User $user, Collection $pendingTasks)
    {
        $this->user = $user;
        $this->pendingTasks = $pendingTasks;
    }

    public function build()
    {
        return $this->view('emails.daily_pending_tasks')
                    ->subject('Your Pending Tasks for Today')
                    ->with([
                        'user' => $this->user,
                        'pendingTasks' => $this->pendingTasks,
                    ]);
    }
}
