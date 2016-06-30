<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Tags extends Model
{
    protected $table = 'tags';


    /**
     * Get topics from Tags name
     * @param  string  $id
     * @return array
     */
    public function topics($id)
    {
        $uid = '0';

        if(Auth::user()){
            $uid = Auth::user()->uuid;
        }

        return  DB::table('tags')
            ->join('topics', 'tags.topic_uuid', '=', 'topics.uuid')
            ->join('channel','topics.channel','=','channel.id')
            ->join('users', 'topics.uid', '=', 'users.uuid')
            ->leftJoin('user_vote', function($join)use($uid)
            {
                $join->on('topics.uuid', '=', 'user_vote.topic_uuid')
                    ->where('user_vote.user_uuid', '=', $uid );

            })
            ->where('tags.title',clean($id))
            ->select('topics.*',
                     'users.firstname','users.lastname','users.displayname','users.followers','users.avatar',
                     'channel.name as channel_name','channel.slug as channel_slug',
                     'user_vote.activity as voteActivity')
            ->get();
    }


    /**
     * Trending tag - order by latest
     */
    public function trending()
    {
        $list = DB::table($this->table)
            ->select('title',DB::raw('count(id) as tag_count'))
                ->groupBy('title')
                ->orderBy('tag_count','desc')
                ->get();

        return $list;
    }


    /**
     * Trending tag channel - order by latest
     * @param  int  $id
     */
    public function trendingTagsChannel($id)
    {
        $list = DB::table($this->table)
            ->where('channel_id',$id)
            ->select('title',DB::raw('count(id) as tag_count'))
            ->groupBy('title')
            ->orderBy('tag_count','desc')
            ->get();

        return $list;
    }


    /**
     * Get the most upvote person from this tag
     * @param  string  $id
     * @return array
    */
    public function mostUpvotePerson($id)
    {
        return DB::table('experts')
            ->join('users', 'experts.user_uuid', '=', 'users.uuid')
            ->where('title',clean($id))
            ->select('experts.*',
                     'users.firstname','users.lastname','users.displayname','users.followers','users.avatar')
            ->get();
    }
}
