<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'uuid', 'email', 'password',
        'gender','ext_id','ext_source','ext_verified','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Questions user posted
     * @params uuid $id
     * @returns array
     */
    public function postedQuestions($id)
    {
        return  DB::table('topics')->where('uid', $id)
                    ->join('channel', 'topics.channel', '=', 'channel.id')
                    ->join('users', 'topics.uid', '=', 'users.uuid')
                    ->leftJoin('user_vote', function($join)use($id)
                    {
                        $join->on('topics.uuid', '=', 'user_vote.topic_uuid')
                            ->where('user_vote.user_uuid', '=', $id );

                    })
                    ->select('topics.*',
                             'users.firstname','users.lastname','users.displayname','users.followers','users.avatar',
                             'channel.name as channel_name', 'channel.slug as channel_slug',
                             'user_vote.activity as voteActivity')
                    ->get();
    }


    /**
     * Answers user posted
     * @params uuid $id
     * @returns array
     */
    public function postedAnswer($id)
    {
        return DB::table('topics_answers')->where('user_uuid',$id)
                    ->join('topics','topics_answers.topic_uuid','=','topics.uuid')
                    ->select('topics_answers.*','topics.topic')
                    ->get();
    }

    /**
     * Get the list of user expertise
     * @params uuid $id
     * @returns array
     */
    public function userExpertise($id)
    {
        return  DB::table('experts')
                    ->where('user_uuid',$id)
                    ->get();
    }
}
