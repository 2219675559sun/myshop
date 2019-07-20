<?php

namespace App\Http\Model\Index;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
