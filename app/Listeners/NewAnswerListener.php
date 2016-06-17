<?php

namespace App\Listeners;

use App\Events\NewAnswer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewAnswerListener
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
     * Event will notify followers that there is new answer to this topic
     *
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle(NewAnswer $event)
    {

        //Get the list of followers on this question
        $followers  = DB::table('topics_follow')
                        ->join('users','topics_follow.uuid','=','users.uuid')
                        ->join('topics','topics_follow.topic_id','=','topics.uuid')
                        ->where('topic_id',$event->answer->topic_uuid)
                        ->select('users.firstname','users.lastname','users.displayname','users.email',
                                 'topics.topic')
                        ->get();

        foreach($followers as $follower)
        {
            Mail::send('emails.new_answer', ['follower' => $follower], function ($m) use ($follower) {
                $m->from('no-reply@qanya.com', 'Qanya?');
                $m->to($follower->email, "$follower->firstname $follower->lastname")
                    ->subject('มีคำตอบใหม่ใน  '.strip_tags($follower->topic));
            });
        }
    }
}
