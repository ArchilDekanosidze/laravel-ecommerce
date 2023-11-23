<?php

namespace App\Listeners;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->hasEmail() ? $event->user->sendEmailVerificationNotification() : null;
    }
}
