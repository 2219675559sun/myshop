<?php

namespace App\Http\Model\Index;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
