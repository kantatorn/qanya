<?php

namespace App\Http\Controllers;

use App\Answers;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Channel;
use App\Topics;
use App\Tags;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


use SEOMeta;
use OpenGraph;
use Twitter;
## or
use SEO;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->action('HomeController@index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()) {


            $channels = Channel::all();

            return view('pages.create',compact('channels'));
        }
        else{
            return redirect()->action('HomeController@index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user())
        {
            //Creating unique ID (might need to change later)
            $topicUUID = Carbon::now()->timestamp;
            $slug=str_slug($request->topic, "-");

            //if cannot convert to slug, then use normal text
            if(empty($slug))
                $slug=$request->topic;

            //Creat slug
            $topicSlug = $slug . '-' . $topicUUID;

            //Generate tag list for topic table
            $taglist = implode(",", $request->tags);

            $topic = new Topics();
            $topic->uuid = $topicUUID;
            $topic->uid = Auth::user()->uuid;
            $topic->anon = $request->anon;
            $topic->topic = clean($request->topic);
            $topic->channel = $request->channel;
            $topic->tags        = $taglist;
            $topic->slug    = clean(str_replace(" ", "-", $topicSlug));

            $topic->save();


            //Tags - to store in tags table
            $tag_data = array();
            $count=0;

            //Insert tags in another table
            foreach($request->tags as $tag)
            {
                //Master link of tags
                $tag_data[$count] = array(  'topic_uuid'=>$topicUUID,
                                            'title'=>clean($tag),
                                            'created_at'=> date("Y-m-d H:i:s")
                                         );
                $count++;
            }
            Tags::insert($tag_data);
            //end tags

            //if user is the one created question, we set them to follow topic automatically
            $request = new Request();
            $request->topic = $topicUUID;
            $this->follow($request);


            return $topicUUID;

        }else{
            return redirect()->action('HomeController@index');
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
        $topic = Cache::remember('answer_cache_'.$id,1,function() use ($id) {
            return  DB::table('topics')
                    ->join('channel', 'topics.channel', '=', 'channel.id')
                    ->select('topics.*', 'channel.name as channel_name', 'channel.slug as channel_slug')
                    ->where('topics.uuid', $id)
                    ->first();
        });

        $similar_topics =
                DB::table('topics')
                ->join('channel','topics.channel','=','channel.id')
                ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
                ->where('topics.channel',$topic->channel)
                ->take(15)
                ->get();

        if(empty($topic))
        {
            abort(404);
        }else{


            /* SEO */
            SEO::setTitle($topic->topic. ' Qanya');
            SEO::setDescription($topic->topic);
            SEO::opengraph()->setUrl('http://current.url.com');
            SEO::opengraph()->addProperty('type', 'articles');
            SEO::twitter()->setSite('@LuizVinicius73');
            /* END SEO */


            //Incrementing views, will use REDIS later
            DB::table('topics')->increment('views');

            $answer = new Answers();
            $answers = $answer->answerList($id);

            return view('pages.page')->with('topic',$topic)
                                    ->with('similar_topics',$similar_topics)
                                    ->with('answers',$answers);
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
     * Follow question
     *
     * @param  int  $id
     */
    public function follow(Request $request)
    {
        $db_table = DB::table('topics_follow');

        //checking if the data exist along with the active flag
        $is_following = $db_table
                        ->where('uuid',Auth::user()->uuid)
                        ->where('topic_id',$request->topic)
                        ->where('flg',1)
                        ->count();

        //If user is not following this question
        if($is_following == 0){
            $db_table->insert([
                                'uuid'      => Auth::user()->uuid,
                                'topic_id'    => $request->topic,
                                'created_at'=> Carbon::now()
                                ]);
            //Increment follow
            DB::table('topics')->where('uuid',$request->topic)
                               ->increment('follow');

            $is_following = 1;
        }else{
            $db_table
                ->where('uuid',Auth::user()->uuid)
                ->where('topic_id',$request->topic)
                ->delete();

            //Decrement follow
            DB::table('topics')->where('uuid',$request->topic)
                               ->decrement('follow');

            $is_following = 0;
        }

        //Count the total followers
        $follow_count = $db_table->where('topic_id',$request->topic)->count();



        return response()->json(['following' => $is_following,'follow_count' => $follow_count]);
    }


    /**
     * Upvote question
     */
    public function upvote()
    {

    }

}
