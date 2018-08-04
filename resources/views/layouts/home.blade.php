<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $nav)<a href="{{$nav->nav_url}}"><span>{{$nav->nav_name}}</span><span class="en">{{$nav->nav_alias}}</span></a>@endforeach
    </nav>
</header>
@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($news as $new)
            <li><a href="{{url('a/'.$new->art_id)}}" title="{{$new->art_title}}" target="_blank">{{$new->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($views as $view)
            <li><a href="{{url('a/'.$view->art_id)}}" title="{{$view->art_title}}" target="_blank">{{$view->art_title}}</a></li>
        @endforeach
    </ul>
@show
<footer>
    <p>{!! Config::get('web.copyright') !!} {!! Config::get('web.web_count') !!}</p>
</footer>
</body>
</html>
