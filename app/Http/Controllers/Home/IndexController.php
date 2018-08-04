<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Home\CommonController;

class IndexController extends CommonController
{
    public function index()
    {
        $hots=Article::orderBy('art_view','desc')->take(6)->get();
        $articles=Article::orderBy('art_time','desc')->paginate(5);
        $links=Link::orderBy('link_order')->take(3)->get();
        return view('home.index',compact('hots','articles','news','views','links'));
    }

    public function cate($cate_id)
    {
        $articles=Article::where('cat_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        Category::where('cate_id',$cate_id)->increment('cate_view');
        $cate=Category::find($cate_id);
        $subcate=Category::where('cate_pid',$cate_id)->get();
        return view('home.list',compact('cate','articles','subcate'));
    }

    public function art($art_id)
    {
        $article=Article::Join('category','article.cat_id','=','category.cate_id')->find($art_id);
        Article::where('art_id',$art_id)->increment('art_view');
        $data['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $data['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $field=Article::where('cat_id',$article->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('article','data','field'));
    }
}
