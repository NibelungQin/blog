@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    {{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}

            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--@foreach($categorys as $category)--}}
                                {{--@if($category->cate_pid==0)--}}
                            {{--<option value="{{url('admin/category/')}}">{{$category->cate_name}}</option>--}}
                                {{--@endif--}}
                                {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>文章管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">ID</th>
                        <th>标题</th>
                        <th>编辑</th>
                        <th>点击</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($articles as $article)
                    <tr>
                        <td class="tc">{{$article->art_id}}</td>
                        <td>
                            <a href="#">{{$article->art_title}}</a>
                        </td>
                        <td>{{$article->art_editor}}</td>
                        <td>{{$article->art_view}}</td>
                        <td>{{$article->art_time}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$article->art_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delcate({{$article->art_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$articles->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function delcate(art_id) {
            layer.confirm('是否删除文章？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/article/')}}/"+art_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                    if(data.status==0){
                        layer.alert(data.msg, {icon: 5});
                    }else {
                        layer.alert(data.msg, {icon: 6});
                        location.href=location.href
                    }
                })
            });
        }
    </script>
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>
        @endsection
