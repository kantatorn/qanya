<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Experts extends Model
{
    protected $table = 'experts';



    /**
     * Get list of user expertise
     *
     * @param  int  $user_uuid
     * @return array
     */
    public function userExpertise($user_uuid, $limit=3)
    {

        $user_expertise = DB::table($this->table)
                            ->where('user_uuid',$user_uuid)
                            ->take($limit)
                            ->get();
        return $user_expertise;
    }
}
