<?php

namespace App\Jobs\Notification\Email;

use App\Jobs\Notification\Email\SendEmail;
use App\Models\User;
use App\Services\Notification\Email\SendEmailProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $mailable;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Mailable $mailable)
    {
        $this->user = $user;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(SendEmailProvider $sendEmail)
    {
        return $sendEmail->send($this->user, $this->mailable);
    }
}
