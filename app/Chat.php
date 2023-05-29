<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //カラムに挿入するものを指定
    protected $fillable = ['buyer_id', 'seller_id', 'idea_id'];

    //他のモデルとの関係
    public function buyer()
    {
        return $this->belongsTo('App\User');
    }

    public function seller()
    {
        return $this->belongsTo('App\User');
    }

    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
