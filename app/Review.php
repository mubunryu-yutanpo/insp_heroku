<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //カラムに挿入するものを指定
    protected $fillable = ['user_id', 'idea_id', 'comment', 'score'];

    //他のモデルとの関係
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function idea(){
        return $this->hasMany('App\Idea');
    }
}
