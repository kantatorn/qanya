<?php

namespace App\Listeners;

use App\Events\AnonPost;
use App\Events\WelcomeUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AnonPostListener
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
    public function handle(AnonPost $id)
    {

//        echo $question->uuid;
        print_r($id->user);


        return Mail::send('emails.admin_anon_post', ['question' => $id], function ($m) use ($id) {
            $m->from('admin@qanya.com', 'Qanya.com');
            $m->to('admin@qanya.com', "Question verify")
                ->subject('Verify this post '.$id->user);
        });
    }
}
