<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Nav;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        $news=Article::orderBy('art_time','desc')->take(8)->get();
        $views=Article::orderBy('art_view','desc')->take(5)->get();
        $navs=Nav::all();
        View::share('navs',$navs);
        View::share('views',$views);
        View::share('news',$news);
    }
}
