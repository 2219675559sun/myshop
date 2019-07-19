<?php

namespace App\http\Index\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'reg_time';
    public function getUserAttribute($value)
    {
        if($value==0){
            return $value='超级管理员';
        }
        if($value==1){
            return $value='普通会员';
        }
        if($value==2){
            return $value='管理员';
        }
    }
    public function getIsUserAttribute($value)
    {
        return $value==1?'正常':'禁用';
    }
}
