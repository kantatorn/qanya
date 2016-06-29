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

        $latestAnswer = DB::table('topics_answers')->where('topic_uuid',$event->answer->topic_uuid)
                        ->orderby('created_at','DESC')
                        ->first();

        foreach($followers as $follower)
        {
            Mail::send('emails.new_answer', ['follower' => $follower , 'topic' => $latestAnswer], function ($m) use ($follower,$latestAnswer) {
                $m->from('no-reply@qanya.com', 'Qanya?');
                $m->to($follower->email, "$follower->firstname $follower->lastname")
                    ->subject('มีคำตอบใหม่ใน  '.strip_tags($follower->topic));
            });
        }
    }
}
