<?php

namespace App\Http\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey="id";
    public $timestamps = false;
    protected $dates = [
        'add_time',
    ];
    public function getIsUpAttribute($value)
    {
        return  $value==1?'是':'否';
    }
    public function getIsNewAttribute($value)
    {
        return  $value==1?'是':'否';
    }
}
