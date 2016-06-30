<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class Topics extends Model
{
    protected $table = 'topics';


    /**
     * Retrieve data from channel feed
     * @param string list
     * @return Array
    */
    public function getChannelsFeed($list)
    {
        $uid = '0';

        if(Auth::user()){
            $uid = Auth::user()->uuid;
        }

        $arr=explode(",",$list);
        //Make sure that questions are active and verified
        return DB::table('topics')
            ->join('channel','topics.channel','=','channel.id')
            ->join('users', 'topics.uid', '=', 'users.uuid')
            ->leftJoin('user_vote', function($join)use($uid)
            {
                $join->on('topics.uuid', '=', 'user_vote.topic_uuid')
                    ->where('user_vote.user_uuid', '=', $uid );

            })
            ->where('topics.flg','=',1)
            ->where('topics.verified','=',1)
            ->whereIn('topics.channel', $arr)
            ->select('topics.*',
                     'users.firstname','users.lastname','users.displayname','users.followers','users.avatar',
                     'channel.name as channel_name','channel.slug as channel_slug',
                     'user_vote.activity as voteActivity')
            ->get();
    }

    /**
     * Get the lastest question
     * @return Array
    */
    public function latestQuestion()
    {
        $uid = '0';

        if(Auth::user()){
            $uid = Auth::user()->uuid;
        }

        //Make sure that questions are active and verified
        return DB::table('topics')
                ->join('channel','topics.channel','=','channel.id')
                ->join('users', 'topics.uid', '=', 'users.uuid')
                ->leftJoin('user_vote', function($join)use($uid)
                {
                    $join->on('topics.uuid', '=', 'user_vote.topic_uuid')
                        ->where('user_vote.user_uuid', '=', $uid );

                })
                ->where('topics.flg','=',1)
                ->where('topics.verified','=',1)
                ->select('topics.*',
                         'users.firstname','users.lastname','users.displayname','users.followers','users.avatar',
                         'channel.name as channel_name','channel.slug as channel_slug',
                         'user_vote.activity as voteActivity',
                         DB::raw('case when
                                    user_vote.user_uuid is null
                                    then 0 else 1
                                    end as isVoted'))
                ->get();
    }


    /**
     * Get the questions that has no answesrs
     * @return Array
    */
    public function noAnswers()
    {
        $uid = '0';

        if(Auth::user()){
            $uid = Auth::user()->uuid;
        }

        return DB::table('topics')
            ->join('channel','topics.channel','=','channel.id')
            ->join('users', 'topics.uid', '=', 'users.uuid')
            ->leftJoin('user_vote', function($join)use($uid)
            {
                $join->on('topics.uuid', '=', 'user_vote.topic_uuid')
                    ->where('user_vote.user_uuid', '=', $uid );

            })
            ->where('topics.answer','=',0)
            ->select('topics.*',
                     'users.firstname','users.lastname','users.displayname','users.followers','users.avatar',
                     'channel.name as channel_name','channel.slug as channel_slug',
                     'user_vote.activity as voteActivity')
            ->get();
    }
}
