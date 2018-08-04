@extends('layouts/home')
@section('info')
    <title>{{$article->art_title}}-{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$article->art_tag}}" />
    <meta name="description" content="{{$article->art_description}}" />
@endsection
@section('content')
    <article class="blogs">
        {{--<span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="/news/s/">慢生活</a></span>--}}
        <h1 class="t_nav"><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$article->cate_id)}}" class="n2">{{$article->cate_name}}</a></h1>
        <div class="index_about">
            <h2 class="c_titile">{{$article->art_title}}</h2>
            <p class="box_c"><span class="d_time">发布时间：{{$article->art_time}}</span><span>编辑：{{$article->art_editor}}</span><span>查看次数：{{$article->art_view}}</span></p>
            <ul class="infos">
                {!! $article->art_content !!}
            </ul>
            <div class="keybq">
                <p><span>关键字词</span>：{{$article->art_tag}}</p>

            </div>
            <div class="ad"> </div>
            <div class="nextinfo">
                <p>上一篇：
                @if($data['pre'])
                    <a href="{{url('a/'.$data['pre']->art_id)}}">{{$data['pre']->art_title}}</a></p>
                @else
                    <span>没有上一篇文章</span>
                @endif
                <p>上一篇：
                @if($data['next'])
                    <a href="{{url('a/'.$data['next']->art_id)}}">{{$data['next']->art_title}}</a></p>
                @else
                    <span>没有下一篇文章</span>
                @endif
            </div>
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($field as $f)
                    <li><a href="{{url('a/'.$f->art_id)}}" title="{{$f->art_title}}">{{$f->art_title}}</a></li>
                    @endforeach>
                </ul>
            </div>
        </div>
        <aside class="right">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="blank"></div>

            <div class="news">
                @parent
            </div>
            <div class="visitors">
                <h3>
                    <p>最近访客</p>
                </h3>
                <ul>
                </ul>
            </div>
        </aside>
    </article>
@endsection
