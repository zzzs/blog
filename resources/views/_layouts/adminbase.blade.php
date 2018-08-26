<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut  icon" type="image/x-icon" href="{{ asset('/image/favicon16.ico') }}" media="screen"  />
	<title>XL ADMIN</title>

	<!-- <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> -->
	<link href="{{ asset('/plugins/bootstrap/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/common.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/admin/main.css') }}" rel="stylesheet">
	<link href="{{ asset('/plugins/confirm/jquery-confirm.min.css') }}" rel="stylesheet">

	<script src="{{ asset('/plugins/jquery/jquery-3.0.0.min.js') }}"></script>
	<script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/plugins/confirm/jquery-confirm.min.js') }}"></script>
	<script src="{{ asset('/plugins/underscore-min.js') }}"></script>
	<script src="{{ asset('/plugins/particleslider/js-particleslider.js') }}"></script>
	<script src="{{ asset('/js/common.js') }}"></script>

	<!-- Fonts -->
  <!-- <link href='http://fonts.useso.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->
</head>
<body>
<!-- 	<div style="background: #00B38C;height: 60px;color:#fff;">#00B38C</div>
	<div style="background: #00B0F0;height: 60px;color:#fff;">#00B0F0</div>
	<div style="background: #82ABBA;height: 60px;color:#fff;">#82ABBA</div>
	<div style="background: #A2B4BA;height: 60px;color:#fff;">#A2B4BA</div>
	<div style="background: #373E40;height: 60px;color:#fff;">#373E40</div>

	<hr>
	<div style="background: #393938;height: 60px;color:#fff;">#393938</div>
	<div style="background: #1A9F8C;height: 60px;color:#fff;">#1A9F8C</div>
	<div style="background: #ec2e4f;height: 60px;color:#fff;">#ec2e4f</div>
	<div style="background: #b3b3b3;height: 60px;color:#fff;">#b3b3b3</div>
	<div style="background: #e0e0e0;height: 60px;color:#fff;">#e0e0e0</div>
 -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/admin">XL ADMIN</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/admin/articles">文章</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="/admin/tagtypes">标签类型</a></li>
					<li><a href="/admin/tags">标签</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
						<li><a href="/">前台首页</a></li>
					@if (Auth::guest())
						<li><a href="/auth/login">登录</a></li>
						<li><a href="/auth/register">注册</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">退出</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

</body>
</html>
