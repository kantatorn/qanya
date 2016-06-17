<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tags;
use App\User;
use Illuminate\Http\Request;

use App\Topics;
use App\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('init_check');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $topics = new Topics();

        $topicList = $topics->latestQuestion();
        $noAnswers = $topics->noAnswers();

        $channels = Channel::all();

        $tags = new Tags();
        $trendingTags = $tags->trending();

        $channelFeed = null;
        if(Auth::user()) {
            $channelFeed = $topics->getChannelsFeed(Auth::user()->channels);
        }


        return view('welcome',compact('channels'))
                ->with('topics',$topicList)
                ->with('noAnswers',$noAnswers)
                ->with('channelFeed',$channelFeed)
                ->with('trendingTags',$trendingTags);
    }

    //Redirect to the previous page
    public function previous()
    {
        return redirect()->intended();
    }

    public function init_check()
    {
        $channels = Channel::all();
        if(Auth::user())
        {
            return view('init-check.displayname',compact('channels'));
        }
        else
        {
            return redirect()->intended();
        }
    }


}
