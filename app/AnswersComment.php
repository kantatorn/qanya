<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnswersComment extends Model
{
    protected $table = 'topics_answers_comments';


    /**
     * Display answers per question ID
     *
     * @param  int  $id
     * @return array
     */
    public function lists($id)
    {
        $list = DB::table($this->table)
            ->join('users', 'topics_answers_comments.user_uuid', '=', 'users.uuid')
            ->where('topics_answers_comments.topic_answers_uuid',$id)
            ->select('topics_answers_comments.*',
                     'users.firstname','users.lastname','users.displayname','users.followers')
            ->orderby('topics_answers_comments.created_at','DESC')
            ->get();
        return $list;
    }
}
