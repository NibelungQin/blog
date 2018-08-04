@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;添加配置项
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项管理</h3>
            @if(count($errors)>0)
                <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                       <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$error}}</p>
                @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>配置项列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>配置项标题：</th>
                    <td>
                        <input type="text" name="conf_title">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>变量名：</th>
                    <td>
                        <input type="text" name="conf_name">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项变量名必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th>类型：</th>
                    <td>
                        <input type="radio" name="filed_type" checked onclick="showTr()" value="input">input
                        <input type="radio" name="filed_type" onclick="showTr()" value="textarea">textarea
                        <input type="radio" name="filed_type" onclick="showTr()" value="radio">radio
                    </td>
                </tr>
                <tr class="filed_value">
                    <th>类型值：</th>
                    <td>
                        <input type="text" class="lg" name="filed_value"><br>
                        <span><i class="fa fa-exclamation-circle yellow"></i>radio类型：0|开启  1|关闭</span>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="conf_order" value="0">
                    </td>
                </tr>
                <tr>
                    <th>备注：</th>
                    <td>
                        <textarea name="conf_tips" id="" cols="30" rows="10"></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        showTr();
        function showTr() {
            var type=$('input[name=filed_type]:checked').val();
            if(type=='radio'){
                $('.filed_value').show();
            }else {
                $('.filed_value').hide();
            }

        }
    </script>
        @endsection
