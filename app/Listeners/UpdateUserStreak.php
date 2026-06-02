<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class UpdateUserStreak
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
    public function handle(Login $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        if (!$user->last_login_at) {
            $user->current_streak = 1;
            $user->last_login_at = Carbon::now();
        } else {
            $lastLogin = Carbon::parse($user->last_login_at);
            
            if ($lastLogin->isYesterday()) {
                $user->current_streak += 1;
                $user->last_login_at = Carbon::now();
            } elseif ($lastLogin->isBefore(Carbon::yesterday())) {
                $user->current_streak = 1;
                $user->last_login_at = Carbon::now();
            }
            // If they logged in today, do nothing to the streak.
        }

        $user->save();
    }
}
