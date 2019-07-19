<?php

namespace App\Http\Admin\Model;

use Illuminate\Database\Eloquent\Model;

class Cgoods extends Model
{
    protected $table = 'cgoods';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = [
        'add_time',
    ];
}
