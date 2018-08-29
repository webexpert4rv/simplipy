<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewMessage extends Model
{
    //
    protected $table = "new_messages";

    public function agent()
    {
        return $this->belongsTo('App\UserProfile', 'agent_id','user_id');
    }
}
