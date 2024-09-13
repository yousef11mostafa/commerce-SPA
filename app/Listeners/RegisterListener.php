<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Jobs\SendWelcometoRegisterdUser;
use App\Mail\RegisterEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RegisterListener
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
    public function handle(RegisterEvent $event): void
    {
        // first assign role to the registerd user
         $event->user->assignRole("user");

        // dispatch job for sending email to welcome registerd user
        SendWelcometoRegisterdUser::dispatch($event->user);

    }
}
