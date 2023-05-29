<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'user_id', 'content'];

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
