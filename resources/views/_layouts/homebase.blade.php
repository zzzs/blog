<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="baidu-site-verification" content="wPG9YCCs3g" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="章显雷,我们俩,php,CodeIgniter,Laravel,TinyLara">
  <meta name="description" content="{{$meta_desc}}">
  <link rel="shortcut  icon" type="image/x-icon" href="{{ asset('/image/favicon16.ico') }}" media="screen"  />
  <title>{{$website}}</title>

  <link href="{{ asset('/plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/plugins/bootstrap/app.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/home/main.css') }}" rel="stylesheet">
  <link href="{{ asset('/plugins/confirm/jquery-confirm.min.css') }}" rel="stylesheet">

  <!-- Fonts -->
  <!-- <link href='http://fonts.useso.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->

  <script src="{{ asset('/plugins/jquery/jquery-3.0.0.min.js') }}"></script>
  <script src="{{ asset('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/plugins/particleslider/js-particleslider.js') }}"></script>
  <script src="{{ asset('/plugins/confirm/jquery-confirm.min.js') }}"></script>
  <script src="{{ asset('/plugins/underscore-min.js') }}"></script>

  <script src="{{ asset('/js/common.js') }}"></script>


</head>
<body>
  <!-- head -->
  <div id="head">
    <!-- <div id="title"> -->
    <p class="website">{{$website}}</p>
    <h3>{{$motto}}</h3><!-- {{ Inspiring::quote() }} -->
    <!-- </div> -->
  </div>
  <!-- head -->

  <!-- nav -->
  <div id="nav" class="navbar-wrapper">
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{$home_page}}</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav main_menus">
              @foreach ($main_menus as $menu)
              <li><a href="{{ URL('/?cate='.$menu['tag_id']) }}">{{$menu['name']}}<span class="sr-only"></span></a></li>
              @endforeach
            </ul>
            <form action="{{ URL('/') }}" method="GET" class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="搜一搜" value="{{$search or ''}}">
              </div>
              <button type="submit" class="btn btn-default">搜搜</button>
            </form>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
  </div>
  <!-- nav -->
  @yield('content')

  @if (!empty($action))
  <link href="{{ asset('/css/home/') }}/{{$action}}.css" rel="stylesheet">
  @endif
  <!-- <script src="{{ asset('/js/home/') }}/{{$action}}.js"></script> -->

  <div class="container">
    <div id="footer" style="text-align: center; margin: 50px 0 0; padding: 40px;">
      <div id="link">
        <span>友情链接：</span>
        @foreach ($love_links as $love_link)
        <a target="_blank" href="{{$love_link['extra']}}">{{$love_link['name']}}</a>
        @endforeach
      </div>
      ©2016.06-{!! date('Y.m') !!} <a href="/" class="xl">Xl</a> <a href="http://www.miibeian.gov.cn/" target="_brank" class="xl">浙ICP备16037643号</a>
    </div>
  </div>

</body>
</html>
