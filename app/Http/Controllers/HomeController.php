<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tags;
use Illuminate\Http\Request;

use App\Topics;
use App\Channel;
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
        $this->middleware('web');
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

        $channels = Channel::all();

        $tags = new Tags();
        $trendingTags = $tags->trending();

        return view('welcome',compact('channels'))
                ->with('topics',$topicList)
                ->with('trendingTags',$trendingTags);
    }

    //Redirect to the previous page
    public function previous()
    {
        return redirect()->intended();
    }


}
