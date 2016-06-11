<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tags extends Model
{
    protected $table = 'tags';


    /**
     * Get topics from Tags name
     *
     * @param  string  $id
     * @return array
     */
    public function topics($id)
    {
        return  DB::table('tags')
            ->join('topics', 'tags.topic_uuid', '=', 'topics.uuid')
            ->join('channel','topics.channel','=','channel.id')
            ->where('tags.title',clean($id))
            ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
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
}
