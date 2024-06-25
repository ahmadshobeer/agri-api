<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;

class SendEmailVerificationNotification implements ShouldQueue
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    /* public function __construct()
    {
        //
    } */

    /**
     * Handle the event.
     */
    public function handle(Registered $event)
    {
        //
        // $event->user->sendEmailVerificationNotification();
        $event->user->notify(new VerifyEmail);
    }
}
