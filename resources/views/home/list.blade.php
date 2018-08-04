@extends('layouts/home')
@section('info')
    <title>{{$cate->cate_name}}-{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$cate->cate_keywords}}" />
    <meta name="description" content="{{$cate->cate_description}}。" />
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{$cate->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a></h1>
        <div class="newblog left">
            @foreach($articles as $article)
            <h2>{{$article->art_title}}</h2>
            <p class="dateview"><span>{{$article->art_time}}</span><span>作者：{{$article->art_editor}}</span><span>分类：[<a href="{{url('cate/'.$cate->cate_id)}}">{{$cate->cate_name}}</a>]</span></p>
            <figure><img src="{{url($article->art_thumb)}}"></figure>
            <ul class="nlist">
                <p>{{$article->art_description}}</p>
                <a title="{{$article->art_title}}" href="{{url('a/'.$article->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
            @endforeach
            <div class="page">
                {{$articles->links()}}
            </div>
        </div>
        <aside class="right">
            @if($subcate->all())
            <div class="rnav">
                <ul>
                    @foreach($subcate as $k=>$sub)
                    <li class="rnav{{$k+1}}"><a href="{{url('cate/'.$sub->cate_id)}}" target="_blank">{{$sub->cate_name}}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Baidu Button BEGIN -->
                <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
                <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
                <script type="text/javascript" id="bdshell_js"></script>
                <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
                </script>
                <!-- Baidu Button END -->
            <div class="news">
                @parent
            </div>
            <div class="visitors">
                <h3><p>最近访客</p></h3>
                <ul>

                </ul>
            </div>

        </aside>
    </article>
@endsection
