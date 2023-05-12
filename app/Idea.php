<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    //カラムに挿入するものを指定
    protected $fillable = ['user_id', 'category_id', 'name', 'summary', 'description', 'price'];

    //他のモデルとの関係
    public function check(){
        return $this->belongsTo('App\Check');
    }
    public function purchase(){
        return $this->hasMany('App\Purchase');
    }
    public function review(){
        return $this->hasMany('App\Review');
    }
}
