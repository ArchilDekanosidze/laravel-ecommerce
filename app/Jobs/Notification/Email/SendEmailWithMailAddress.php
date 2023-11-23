<?php

namespace App\Jobs\Notification\Email;

use App\Services\Notification\Email\SendEmailWithMailAddressProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailWithMailAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mailAddress;
    private $mailable;

    /**
     * Create a new job instance.
     */
    public function __construct($mailAddress, Mailable $mailable)
    {
        $this->mailAddress = $mailAddress;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(SendEmailWithMailAddressProvider $sendEmail)
    {
        return $sendEmail->send($this->mailAddress, $this->mailable);
    }
}
