<?php

namespace App\Http\Controllers;

use App\Experts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //If user login
        if(Auth::user())
        {
            if(empty(Auth::user()->displayname))
            {
                return redirect('/create_displyname');
            }
            else{
                return redirect()->action('UsersController@show',Auth::user()->displayname);
            }
        }
        else
        {
            return redirect()->action('HomeController@index');
        }
    }

    /**
     * Create displayname
     */
    public function create_displayname()
    {
        echo "create user name";
    }

    /**
     * Create user?
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = DB::table('users')->where('displayname',$id)->first();

        //If there is user
        if($userInfo) {

            $user = new User();

            $user_questions = $user->postedQuestions($userInfo->uuid);
//            $user_expertise = $user->userExpertise($userInfo->uuid);
            $user_answers   = $user->postedAnswer($userInfo->uuid);

            return view('profile.user')->with('user', $userInfo)
                                       ->with('user_questions', $user_questions)
                                       ->with('user_answers', $user_answers);
//                                       ->with('user_expertise', $user_expertise);
        }else{
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
     * Add user expertise
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function addExpertise(Request $request)
    {
        if(Auth::user())
        {
            $expert = new Experts();
            $expert->user_uuid  =   Auth::user()->uuid;
            $expert->slug       =   str_replace(' ','-',clean($request->expertise));
            $expert->title      =   clean($request->expertise);
            $expert->text       =   $request->expertise_body;
            $expert->save();

            $user = new User();
            return $user->userExpertise($request->uuid);
        }
        else
        {
            return redirect()->action('HomeController@index');
        }
    }


    /**
     * List user expertise
     *
     *
     */
    public function listExpertise(Request $request)
    {

        $user = new User();
        return $user->userExpertise($request->uuid);
    }
}
