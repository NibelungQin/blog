@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改文章</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>文章列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/article/'.$article->art_id)}}" enctype="multipart/form-data" method="post">
            <input type="hidden" name="_method" value="patch">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>分类：</th>
                    <td>
                        <select name="cat_id">
                            <option value="0"></option>
                            @foreach($categorys as $category)
                            <option value="{{$category->cate_pid}}"
                                @if($category->cate_pid==$article->cat_id)
                                    selected
                                    @endif
                            >{{$category->_cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title" value="{{$article->art_title}}">
                    </td>
                </tr>
                <tr>
                    <th>编辑：</th>
                    <td>
                        <input type="text" class="sm" name="art_editor" value="{{$article->art_editor}}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" size="50" name="art_thumb" value="{{$article->art_thumb}}">
                        <input id="file_upload" onchange="upload()" name="file_upload" type="file"><br>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <img alt="" id="art_thumb_img" style="width: 200px; height: 100px" src="{{$article->art_thumb}}">
                    </td>
                </tr>
                <tr>
                    <th>关键词：</th>
                    <td>
                        <input type="text" class="lg" name="art_tag" value="{{$article->art_tag}}">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description">{{$article->art_description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" type="text/plain" name="art_content"  style="width:860px; height:500px;">{!! $article->art_content !!}</script>
                        <script type="text/javascript">
                        //实例化编辑
                        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                        var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                    </td>
                </tr>
                <tr>
                    <th>发表时间：</th>
                    <td>
                        <input type="date" name="art_time" value="<?php echo date('Y-m-d'); ?>">
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
        function upload() {
            $.post("{{url('admin/article/create')}}",{'_token':'{{csrf_token()}}','_method':'get'},function () {

            })
        }
    </script>
        @endsection
