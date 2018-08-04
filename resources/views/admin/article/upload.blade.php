@extends('layouts/admin')
@section('content')
    <form method="post" enctype="multipart/form-data" action="{{url('admin/upload')}}">
        {{csrf_field()}}
        <input type="file" name="picture">
        <button type="submit"> 提交 </button>
    </form>
    @endsection