<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Channel extends Model
{
    protected $table        = 'channel';
    protected $tag_table    = 'tags';
    protected $topics_table = 'topics';

    /**
     * Get topics from channel ID
     *
     * @param  int  $id
     * @return array
     */
    public function topics($id)
    {
        return  DB::table($this->topics_table)
                ->join('channel', 'topics.channel', '=', 'channel.id')
                ->select('topics.*', 'channel.name as channel_name', 'channel.slug as channel_slug')
                ->where('topics.channel', $id)
                ->orderBy('topics.views','DESC')
                ->get();
    }



    /**
     * Listing topics that has no answers
     *
     * @params int $id
     */
    public function noAnswers($id)
    {
        return  DB::table($this->topics_table)
            ->join('channel', 'topics.channel', '=', 'channel.id')
            ->select('topics.*', 'channel.name as channel_name', 'channel.slug as channel_slug')
            ->where('topics.channel', $id)
            ->where('topics.answer', 0)
            ->get();
    }

    /**
     * Trending tag - order by latest
     *
     * @param  int  $id
     * @return array
     */
    public function tagsTrending($id)
    {
        return  DB::table($this->tag_table)
                ->where('channel_id', $id)
                ->select('title',DB::raw('count(id) as tag_count'))
                ->groupBy('title')
                ->orderBy('tag_count','desc')
                ->get();
    }
}
