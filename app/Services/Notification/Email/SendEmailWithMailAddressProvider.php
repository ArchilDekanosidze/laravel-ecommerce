<?php
namespace App\Services\Notification\Email;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmailWithMailAddressProvider
{

    public function send($mailAddress, Mailable $mailable)
    {
        return Mail::to($mailAddress)->send($mailable);
    }
}
