<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class Answers extends Model
{
    protected $table = 'topics_answers';


    /**
     * Incrementing views for answer
     *
     * @param  int  $id
     * @return null
     */
    public function incrementView($id)
    {
        DB::table($this->table)
            ->where('topics_answers.uuid', $id)
            ->increment('views');
    }

    /**
     * Get answer information by ID
     *
     * @param  int  $id
     */
    public function detail($id)
    {

        $data = Cache::remember('topic_posts_cache_'.$id,1,function() use ($id) {
            return  DB::table($this->table)
                ->join('topics', 'topics_answers.topic_uuid', '=', 'topics.uuid')
                ->join('users', 'topics_answers.user_uuid', '=', 'users.uuid')
                ->where('topics_answers.uuid', $id)
                ->select('topics_answers.*',
                         'users.firstname','users.lastname','users.displayname','users.followers',
                         'topics.topic','topics.uuid as topic_uuid')
                ->first();
        });
        return $data;
    }

    /**
     * Display answers per question ID
     *
     * @param  int  $id
     * @return array
     */
    public function answerList($id)
    {
        $list = DB::table($this->table)
                ->join('topics', 'topics_answers.topic_uuid', '=', 'topics.uuid')
                ->join('users', 'topics_answers.user_uuid', '=', 'users.uuid')
                ->where('topics_answers.topic_uuid',$id)
                ->select('topics_answers.*',
                         'users.firstname','users.lastname','users.displayname','users.followers',
                         'topics.topic','topics.uuid as topic_uuid')
                ->orderby('topics_answers.created_at')
                ->get();
        return $list;
    }


}
