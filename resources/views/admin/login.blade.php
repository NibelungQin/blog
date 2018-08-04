@extends('layouts/admin')
@section('content')
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			<p style="color:red">&nbsp;
				@if(session('msg'))
					{{session('msg')}}
				@endif
			</p>
			<form action="#" method="post">
				{{csrf_field()}}
				<ul>
					<li>
						<input type="text" name="username" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登录"/>
					</li>
				</ul>
			</form>
			<p><a href="{{url('admin/login')}}">返回首页</a> &copy; 2016 Powered by <p>Nibelung Qin</p></p>
		</div>
	</div>
		@endsection
