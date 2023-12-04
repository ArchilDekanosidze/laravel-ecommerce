<?php

namespace App\Services\Notification\Email;

use App\Models\User;
use App\Services\Notification\Email\Exceptions\UserDoesNotHaveEmailAddress;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmailProvider
{
    public function send(User $user, Mailable $mailable)
    {
        $this->haveEmailAddress($user);

        return Mail::to($user)->send($mailable);
    }

    private function haveEmailAddress($user)
    {
        if (is_null($user->email)) {
            throw new UserDoesNotHaveEmailAddress();
        }
    }
}
