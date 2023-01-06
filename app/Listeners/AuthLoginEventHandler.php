<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\User;
use App\Models\Log;

class AuthLoginEventHandler
{

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  User $user
     * @param  $remember
     * @return void
     */
    public function handle(User $user, $remember)
    {
        dd('test login');
        if (Auth::id()) {
            \App\Models\Log::login();
        }
    }
}
