@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">

            <table class="search_tab">
                <tr>
                    <th width="90">配置项标题:</th>
                    <td><input type="text" name="linkname" placeholder="配置项标题"></td>
                    <th width="70">变量名:</th>
                    <td><input type="text" name="linktitle" placeholder="变量名"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/conf/changecontent')}}" method="post">
        {{csrf_field()}}
        <div class="result_wrap">
            <div class="result_title">
                <h3>文章管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>配置项列表</a>
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
                        <th>配置项标题</th>
                        <th>变量名</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($configs as $config)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeorder(this,{{$config->conf_id}})" value="{{$config->conf_order}}">
                        </td>
                        <td class="tc">{{$config->conf_id}}</td>
                        <td>
                            <a href="#">{{$config->conf_title}}</a>
                        </td>
                        <td>{{$config->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$config->conf_id}}">
                            {!!$config->_html!!}</td>
                        <td>
                            <a href="{{url('admin/config/'.$config->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delconf({{$config->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$configs->links()}}
                </div>
            </div>
            <div class="btn_group">
                <input type="submit" onclick="changecontent()" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回" >
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changecontent() {
            alert('配置项更新成功');
        }
        
        function changeorder(obj,conf_id) {
            var conf_order=$(obj).val();
            $.post("{{url('admin/conf/changeorder')}}",{'_token':'{{csrf_token()}}','conf_order':conf_order,'conf_id':conf_id},function (data) {
                if(data.status==0){
                    location.href=location.href;
                    layer.alert(data.msg, {icon: 6});
                }else {
                    layer.alert(data.msg, {icon: 5});
                }
            })
        }
        function delconf(conf_id) {
            layer.confirm('是否删除链接？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/config')}}/"+conf_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                    if(data.status==0){
                        location.href=location.href;
                        layer.alert(data.msg, {icon: 6});
                    }else {
                        layer.alert(data.msg, {icon: 5});
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
