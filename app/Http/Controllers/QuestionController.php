<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Events\AnonPost;
use App\Experts;
use App\Question;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Channel;
use App\Topics;
use App\Tags;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Event;
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
     * CREATE NEW QUESTION TOPIC
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()) {


            $channels = Channel::all();

            return view('pages.create',compact('channels'));
        }
        else
        {
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
            $topic->uuid    = $topicUUID;
            $topic->uid     = Auth::user()->uuid;
            $topic->anon    = $request->anon;
            $topic->topic   = clean($request->topic);
            $topic->text    = clean($request->text);
            $topic->channel = $request->channel;
            $topic->tags    = $taglist;

            //Check if this post is anon if it easy, we manually verify
            if(!$request->anon)
                $topic->verified = 1;


            $topic->slug    = clean(str_replace(" ", "-", $topicSlug));

            $topic->save();


            //If topic is anon
            if($request->anon)
                Event::fire(new AnonPost($topic->id));


            //Tags - to store in tags table
            $tag_data = array();
            $count=0;

            //Insert tags in another table
            foreach($request->tags as $tag)
            {
                //Master link of tags
                $tag_data[$count] = array(  'topic_uuid'=> $topicUUID,
                                            'title'     => clean($tag),
                                            'channel_id'=> $request->channel,
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

        $tags = new Tags();
        $tagsChannel = $tags->trendingTagsChannel($topic->channel);

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

            $userExperts = null;

            //Check if user log in
            if(Auth::user())
            {
                $expert = new Experts();
                $userExperts = $expert->userExpertise(Auth::user()->uuid,99);
//                $userExperts = Experts::where('user_uuid',Auth::user()->uuid)->get();

            }

            //Incrementing views, will use REDIS later
            DB::table('topics')->where('uuid',$id)->increment('views');

            $answer = new Answers();
            $answers = $answer->answerList($id);

            return view('pages.page')->with('topic',$topic)
                                    ->with('similar_topics',$similar_topics)
                                    ->with('tagsChannel',$tagsChannel)
                                    ->with('userExperts',$userExperts)
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
     * @param  \Illuminate\Http\Request  $request
     */
    public function follow(Request $request)
    {
        $db_table = DB::table('topics_follow');

        $question = new Question();
        $is_following = $question->followingStatus(Auth::user()->uuid,$request->topic);

        //If user is not following this question
        if(!$is_following){
            $db_table->insert([
                                'uuid'      => Auth::user()->uuid,
                                'topic_id'    => $request->topic,
                                'created_at'=> Carbon::now()
                                ]);
            //Increment follow
            DB::table('topics')->where('uuid',$request->topic)
                               ->increment('follow');

            $is_following =1;
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

        return $is_following;
    }


    /**
     * Follow status
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function followStatus(Request $request)
    {
        if(Auth::user()) {
            $question = new Question();
            $is_following = $question->followingStatus(Auth::user()->uuid, $request->topic);
            if ($is_following) {
                return 1;
            } else {
                return 0;
            }
        }else{
            abort(403);
        }
    }


    /**
     * Up vote question
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return int
     */
    public function upvote(Request $request)
    {

        if(Auth::user())
        {
            $question = new Question();
            $is_voted = $question->upvoteStatus(Auth::user()->uuid,$request->topic);

            //if already voted for this question
            if($is_voted)
            {

                $this->resetVote($request,'upvote');

                return 0;
            }
            else
            {

                $is_downvoted = $question->downvoteStatus(Auth::user()->uuid,$request->topic);

                if($is_downvoted)
                    $this->resetVote($request,'downvote');

                $this->incrementVote($request,'upvote',1);

                return 1;
            }

        }
        else{
            abort(403);
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
        DB::table('topics')->where('uuid' , $request->topic)->decrement("$vote");

        //remove user vote stat
        DB::table('user_vote')->where('user_uuid' , Auth::user()->uuid)
            ->where('topic_uuid' , $request->topic)
            ->delete();
    }


    /**
     * Increment vote stat
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string   $vote
     * @param  int      $activity (0 or 1)
     */
    public function incrementVote(Request $request, $vote, $activity)
    {
        //increment the upvote
        DB::table('topics')->where('uuid' , $request->topic)->increment("$vote");

        //add new user vote stat
        DB::table('user_vote')->insert(
            [   'user_uuid'     =>  Auth::user()->uuid,
                'topic_uuid'    =>  $request->topic,
                'activity'      =>  $activity
            ]);
    }


    /**
     * Down vote question
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return int
     */
    public function downvote(Request $request)
    {

        if(Auth::user())
        {
            $question = new Question();
            $is_voted = $question->downvoteStatus(Auth::user()->uuid,$request->topic);

            //if already down vote for this question
            if($is_voted)
            {

                $this->resetVote($request,'downvote');

                return 0;
            }
            else
            {

                $is_upvoted = $question->upvoteStatus(Auth::user()->uuid,$request->topic);

                if($is_upvoted)
                    $this->resetVote($request,'upvote');

                $this->incrementVote($request,'downvote',2);

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
            $question = new Question();
            $is_voted = $question->upvoteStatus(Auth::user()->uuid, $request->topic);


            if ($is_voted) {
                return 1;
            } else {
                return 0;
            }
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

}
