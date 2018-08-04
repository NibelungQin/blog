@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 链接列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">

            <table class="search_tab">
                <tr>
                    <th width="70">链接名称:</th>
                    <td><input type="text" name="linkname" placeholder="关键字"></td>
                    <th width="70">标题:</th>
                    <td><input type="text" name="linktitle" placeholder="标题"></td>
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
                <h3>文章管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/link/create')}}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="{{url('admin/link')}}"><i class="fa fa-recycle"></i>链接列表</a>
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
                        <th>链接名称</th>
                        <th>标题</th>
                        <th>链接</th>
                        <th>操作</th>
                    </tr>
                    @foreach($links as $link)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeorder(this,{{$link->link_id}})" value="{{$link->link_order}}">
                        </td>
                        <td class="tc">{{$link->link_id}}</td>
                        <td>
                            <a href="#">{{$link->link_name}}</a>
                        </td>
                        <td>{{$link->link_title}}</td>
                        <td>{{$link->link_url}}</td>
                        <td>
                            <a href="{{url('admin/link/'.$link->link_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delcate({{$link->link_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$links->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeorder(obj,link_id) {
            var link_order=$(obj).val();
            $.post("{{url('admin/lin/changeorder')}}",{'_token':'{{csrf_token()}}','link_order':link_order,'link_id':link_id},function (data) {
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
                $.post("{{url('admin/link/')}}/"+art_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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
