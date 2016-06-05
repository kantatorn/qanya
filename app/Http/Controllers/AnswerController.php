<?php

namespace App\Http\Controllers;

use App\Answers;
use App\AnswersComment;
use App\Experts;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
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

            if($answer->save())
            {
                Mail::send('emails.reminder', ['user' => 'kantatorn.tardthong@gmail.com'], function ($m) {
                    $m->from('hello@app.com', 'Your Application');
                    $m->to('kantatorn.tardthong@gmail.com', 'kantatorn tardthong')->subject('Your Reminder!');
                });
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
}
