<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyToEmail extends Model
{
    //
    protected $table = 'replyto_emails';

    public function userProfile()
    {
        return $this->hasOne('App\UserProfile', 'user_id','user_id');
    }

    public static function checkIfUserReplyTo($user_id){
        if(!empty($user_id)){
            $check = ReplyToEmail::where('user_id',$user_id)->count();
            if($check > 0){
                return 1;
            }
            return 0;
        }
        return 0;

    }
}
