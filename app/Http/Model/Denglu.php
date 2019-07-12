<?php

namespace App\http\model;

use Illuminate\Database\Eloquent\Model;

class Denglu extends Model
{
     protected $table = 'denglu';
     protected $primaryKey='id';
     /**
     * 指示模型是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;
}
