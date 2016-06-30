<?php

namespace App\Http\Controllers;

use App\Experts;
use App\Http\Requests;
use App\Tags;
use App\User;
use Illuminate\Http\Request;

use App\Topics;
use App\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use SEO;

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
    public function index(Request $request)
    {

        /* SEO */
        SEO::setTitle('Qanya.com - หน้าแรก');
        SEO::opengraph()->setUrl($request->url());
        SEO::opengraph()->addProperty('type', 'articles');
        /* END SEO */

        $topics = new Topics();

        $topicList = $topics->latestQuestion();
        $noAnswers = $topics->noAnswers();

        $channels = Channel::all();

        $tags = new Tags();
        $trendingTags = $tags->trending();

        $channelFeed = null;
        $userExperts = null;

        if(Auth::user()) {
            $channelFeed = $topics->getChannelsFeed(Auth::user()->channels);
            $userExperts = Experts::where('user_uuid',Auth::user()->uuid)->get();
        }


        return view('welcome',compact('channels'))
                ->with('topics',$topicList)
                ->with('noAnswers',$noAnswers)
                ->with('channelFeed',$channelFeed)
                ->with('experts',$userExperts)
                ->with('trendingTags',$trendingTags);
    }

    //Redirect to the previous page
    public function previous()
    {
        return redirect()->intended();
    }


    /**
     * Init check for user who created account but haven't gone through verification stage
    */
    public function init_check()
    {
        $channels = Channel::all();
        if(Auth::user())
        {
            //If they haven't gone through the setup
            if(!Auth::user()->init_setup)
            {
                $channels = Channel::all();
                return view('pages.setup',compact('channels'));
            }
            else
            {
                return redirect()->intended();
            }
        }
        else
        {
            return redirect()->intended();
        }
    }


}
