<?php

namespace App\Http\Controllers;

use App\Answers;
use App\AnswersComment;
use App\Events\NewAnswer;
use App\Experts;
use App\Question;
use App\Topics;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Save answers
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()) {

            $answerUUID = Carbon::now()->timestamp;

            $answer = new Answers();
            $answer->uuid       = $answerUUID;
            $answer->user_uuid  = Auth::user()->uuid;
            $answer->topic_uuid = $request->topic;
            $answer->body       = clean($request->text);

            $lastID = $answer;

            //Increment the number of answers for topic
            $topic = new Topics();
            $topic->where('uuid',$request->topic)->increment('answer');

            if($answer->save())
            {
                Event::fire(new NewAnswer($lastID));
                return $answerUUID;
            }

        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answer = new Answers();
        $answerDetail  = $answer->detail($id);


        if(!empty($answerDetail)) {

            $answerComment = new AnswersComment();
            //Increment views for answers
            $answer->incrementView($id);

            $expertise = new Experts();

            $user_expertise =   $expertise->userExpertise($answerDetail->uuid);

            $answerComments = $answerComment->lists($id);

            return view('pages.answer')
                    ->with('user_expertise', $user_expertise)
                    ->with('answer', $answerDetail)
                    ->with('comments',$answerComments);
        }
        else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Post comment answer
     *
     * @param  \Illuminate\Http\Request  $request
     *
     *
     */
    public function commentAnswer(Request $request)
    {

        if(Auth::user())
        {
            $answer = new AnswersComment();
            $answer->topic_answers_uuid = $request->topic;;
            $answer->user_uuid = Auth::user()->uuid;
            $answer->body = clean($request->body);

            $answer->save();
        }
        else
        {
            abort(403);
        }
    }

    /**
     * Up vote Answer
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return int
     */
    public function upvote(Request $request)
    {

        if(Auth::user())
        {
            $answer = new Answers();
            $is_voted = $answer->upvoteStatus(Auth::user()->uuid,$request->answer);

            //if already voted for this question
            if($is_voted)
            {

                //remove user vote stat
                DB::table('user_vote')->where('user_uuid' , Auth::user()->uuid)
                    ->where('topic_uuid' , $request->answer)
                    ->delete();

                return 0;
            }
            else
            {

                $is_downvoted = $answer->downvoteStatus(Auth::user()->uuid,$request->answer);

                if($is_downvoted)
                    $this->resetVote($request,'downvote');

                $this->incrementVote($request,'upvote',3);

                return 1;
            }

        }
        else{
            abort(403);
        }
    }


    /**
     * Up vote status
     * @param  \Illuminate\Http\Request  $request
     */
    public function upvoteStatus(Request $request)
    {
        if(Auth::user()) {
            $answer = new Answers();
            $is_voted = $answer->upvoteStatus(Auth::user()->uuid, $request->answer);

            if ($is_voted) {
                return 1;
            } else {
                return 0;
            }
        }
    }



    /**
     * Down vote Answer
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return int
     */
    public function downvote(Request $request)
    {

        if(Auth::user())
        {
            $answer = new Answers();
            $is_voted = $answer->downvoteStatus(Auth::user()->uuid,$request->topic);

            //if already down vote for this question
            if($is_voted)
            {

                $this->resetVote($request,'downvote');

                return 0;
            }
            else
            {

                $is_upvoted = $answer->upvoteStatus(Auth::user()->uuid,$request->topic);

                if($is_upvoted)
                    $this->resetVote($request,'upvote');

                $this->incrementVote($request,'downvote',0);

                return 1;
            }

        }
        else{
            abort(403);
        }
    }



    /**
     * Down vote status
     * @param  \Illuminate\Http\Request  $request
     */
    public function downvoteStatus(Request $request)
    {
        if(Auth::user()) {
            $question = new Question();
            $is_voted = $question->downvoteStatus(Auth::user()->uuid, $request->topic);

            if ($is_voted) {
                return 1;
            } else {
                return 0;
            }
        }
    }



    /**
     * Reset all the stated $vote
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $vote
     */
    public function resetVote(Request $request,$vote)
    {
        //decrement the upvote
        DB::table('topics_answers')->where('uuid' , $request->answer)->decrement("$vote");

        //remove user vote stat
        DB::table('user_vote')->where('user_uuid' , Auth::user()->uuid)
            ->where('topic_uuid' , $request->answer)
            ->delete();
    }

    /**
     * Increment vote stat
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string   $vote
     * @param  int      $activity (3 upvoteAns or 4 downvoteAns)
     */
    public function incrementVote(Request $request, $vote, $activity)
    {
        //increment the upvote
        DB::table('topics_answers')->where('uuid' , $request->answer)->increment("$vote");

        //add new user vote stat
        DB::table('user_vote')->insert(
            [   'user_uuid'     =>  Auth::user()->uuid,
                'topic_uuid'    =>  $request->answer,
                'activity'      =>  $activity
            ]);
    }



}
