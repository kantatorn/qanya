<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $arr=explode(",",$list);
        //Make sure that questions are active and verified
        return DB::table('topics')
            ->join('channel','topics.channel','=','channel.id')
            ->where('topics.flg','=',1)
            ->where('topics.verified','=',1)
            ->whereIn('topics.channel', $arr)
            ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
            ->get();
    }

    /**
     * Get the lastest question
     * @return Array
    */
    public function latestQuestion()
    {
        //Make sure that questions are active and verified
        return DB::table('topics')
                ->join('channel','topics.channel','=','channel.id')
                ->where('topics.flg','=',1)
                ->where('topics.verified','=',1)
                ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
                ->get();
    }


    /**
     * Get the questions that has no answesrs
     * @return Array
    */
    public function noAnswers()
    {
        return DB::table('topics')
            ->join('channel','topics.channel','=','channel.id')
            ->where('topics.answer','=',0)
            ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
            ->get();
    }
}
