<?php

namespace App\Http\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table='article';
    protected $primaryKey='art_id';
    protected $guarded=['created_at'];
    public $timestamps=false;


    public function setArtTimeAttribute($data)
    {
        $this->attributes['art_time']=Carbon::createFromFormat('Y-m-d',$data);
    }
}
