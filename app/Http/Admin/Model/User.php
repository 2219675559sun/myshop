<?php

namespace App\http\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{ 
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    const CREATED_AT = 'reg_time';

}
