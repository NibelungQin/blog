<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table='navs';
    protected $primaryKey='nav_id';
    protected $guarded=[];
    public $timestamps=false;
}
