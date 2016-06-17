<?php

namespace App\Listeners;

use App\Events\WelcomeUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WelcomeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Event will send Welcome email to new user
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(WelcomeUser $user)
    {

        $user = $user->user;

        return Mail::send('emails.welcome_user', ['user' => $user], function ($m) use ($user) {
            $m->from('sawasdee@qanya.com', 'Qanya.com');
            $m->to($user->email, "$user->firstname $user->lastname")
                ->subject(strip_tags($user->firstname).' -  ยินดีต้อนรับสู่ Qanya! ');
        });

    }
}
