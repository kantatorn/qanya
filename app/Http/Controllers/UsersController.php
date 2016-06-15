<?php

namespace App\Http\Controllers;

use App\Experts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

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
            $user_expertise = $user->userExpertise($userInfo->uuid);
            $user_answers = $user->postedAnswer($userInfo->uuid);

            $IS_USER = FALSE;
            if (Auth::user())
            {
                if ($userInfo->uuid == Auth::user()->uuid) {

                    $IS_USER = TRUE;
                } else {
                    $IS_USER = FALSE;
                }
            }
            return view('profile.user',compact('IS_USER'))->with('user', $userInfo)
                                       ->with('user_questions', $user_questions)
                                       ->with('user_answers', $user_answers)
                                       ->with('user_expertise', $user_expertise);
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
        $userInfo = DB::table('users')->where('displayname',$id)->first();
        return view('profile.edit')->with('user', $userInfo);
    }

    /**
     * Update user basic information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if(Auth::user()) {
            User::where('uuid', Auth::user()->uuid)
                ->update([
                            'firstname'     => $request->data['firstname'],
                            'lastname'      => $request->data['lastname'],
                            'description'   => $request->data['description'],
                            'email'         => $request->data['email']
                         ]);
        }
        else
        {
            abort(403);
        }
    }

    /**
    * Update User's password
    *
    * @param  \Illuminate\Http\Request  $request
    */
    public function updatePassword(Request $request)
    {
        echo print_r($request->data);
        if(Auth::user())
        {
            User::where('uuid', Auth::user()->uuid)->where('password',bcrypt($request->data['oldPass']))
                    ->update([
                                'password' => bcrypt($request->data['newPass'])
                            ]);
        }
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



    /**
     * Upload
     */
    public function uploadAvatar(Request $request)
    {

        if(Auth::user()) {
            $uuid = Auth::user()->uuid;

            //force all image to be jpg for now?
            $img = Image::make($request->data)->encode('jpg');
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();

            $filename = 'img/' . date("YmdHis_") . Auth::user()->displayname . '.jpg';
            $img->save($filename);

            //Save image file to table
            User::where('uuid',"$uuid")->update(['avatar' => '/'.$filename]);

            return '/'.$filename;
        }
    }
}
