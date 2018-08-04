<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $guarded=[];

    public function tree()
    {
        $categorys=$this->orderBy('cate_order','asc')->get();
        $categorys=$this->getTree($categorys,'cate_id','cate_pid','cate_name',0);
        return $categorys;
    }

    public function getTree($data,$filed_id,$filed_pid,$filed_name,$pid)
    {
        $arr=array();
        foreach ($data as $m=>$n){
            if ($n->$filed_pid==$pid){
                $data[$m]['_'.$filed_name]=$data[$m][$filed_name];
                $arr[]=$data[$m];
                foreach ($data as $k=>$v){
                    if ($v->$filed_pid==$n->$filed_id){
                        $data[$k]['_'.$filed_name]='├── '.$data[$k][$filed_name];
                        $arr[]=$data[$k];
                    }
                }
            }
        }
        return $arr;
    }
}
