@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 自定义导航列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">

            <table class="search_tab">
                <tr>
                    <th width="120">自定义导航名称:</th>
                    <td><input type="text" name="linkname" placeholder="自定义导航名称"></td>
                    <th width="120">自定义导航标题:</th>
                    <td><input type="text" name="linktitle" placeholder="自定义导航标题"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>自定义导航管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/nav/create')}}"><i class="fa fa-plus"></i>添加自定义导航</a>
                    <a href="{{url('admin/nav')}}"><i class="fa fa-recycle"></i>自定义导航列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>自定义导航名称</th>
                        <th>自定义导航标题</th>
                        <th>Url</th>
                        <th>操作</th>
                    </tr>
                    @foreach($navs as $nav)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeorder(this,{{$nav->nav_id}})" value="{{$nav->nav_order}}">
                        </td>
                        <td class="tc">{{$nav->nav_id}}</td>
                        <td>
                            <a href="#">{{$nav->nav_name}}</a>
                        </td>
                        <td>{{$nav->nav_alias}}</td>
                        <td>{{$nav->nav_url}}</td>
                        <td>
                            <a href="{{url('admin/nav/'.$nav->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delcate({{$nav->nav_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$navs->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeorder(obj,nav_id) {
            var nav_order=$(obj).val();
            $.post("{{url('admin/na/changeorder')}}",{'_token':'{{csrf_token()}}','nav_order':nav_order,'nav_id':nav_id},function (data) {
                if(data.status==0){
                    location.href=location.href;
                    layer.alert(data.msg, {icon: 6});
                }else {
                    layer.alert(data.msg, {icon: 5});
                }
            })
        }

        function delcate(art_id) {
            layer.confirm('是否删除链接？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/nav/')}}/"+art_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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
