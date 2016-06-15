<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topics extends Model
{
    protected $table = 'topics';


    /**
     * Get the lastest question
    */
    public function latestQuestion()
    {
        return DB::table('topics')
                ->join('channel','topics.channel','=','channel.id')
                ->select('topics.*','channel.name as channel_name','channel.slug as channel_slug')
                ->get();
    }
}
