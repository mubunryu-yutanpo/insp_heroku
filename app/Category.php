<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //カラムに挿入するものを指定
    protected $fillable = ['name'];

    //他のモデルの関係
    public function idea(){
        return $this->hasMany('App\Idea');
    }
}
