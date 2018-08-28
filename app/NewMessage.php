<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewMessage extends Model
{
    //
    protected $table = "new_messages";

    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id');
    }
}
