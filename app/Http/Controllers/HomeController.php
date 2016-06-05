<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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

        $topics = DB::table('topics')
                ->join('channel','topics.channel','=','channel.id')
                ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
                ->get();
        $channels = Channel::all();

        return view('welcome',compact('topics','channels'));
    }

    //Redirect to the previous page
    public function previous()
    {
        return redirect()->back();
    }


}
