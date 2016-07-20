<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$website}}</title>

<!--   <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet"> -->
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/common.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/home/main.css') }}" rel="stylesheet">

  <!-- Fonts -->
  <!-- <link href='http://fonts.useso.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> -->

  <script src="{{ asset('/js/jquery-3.0.0.min.js') }}"></script>
  <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('/js/js-particleslider.js') }}"></script>
  <script src="{{ asset('/js/common.js') }}"></script>

</head>
<body>
 <!-- head -->
 <div id="head">
   <!-- <div style="background: #00B38C;height: 60px;">color0: #00B38C__RGB(0,179,140)</div>
   <div style="background: #00B0F0;height: 60px;">color1: #00B0F0__RGB(0,176,240)</div>
   <div style="background: #82ABBA;height: 60px;">color2: #82ABBA__RGB(130,171,186)</div>
   <div style="background: #A2B4BA;height: 60px;">color3: #A2B4BA__RGB(162,180,186)</div>
   <div style="background: #373E40;height: 60px;">color4: #373E40__RGB(55,62,64)</div> -->
   <!-- <div id="title"> -->
     <!-- <h1>{{$website}}</h1> -->
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
         <ul class="nav navbar-nav">
           @foreach ($main_menus as $menu)
           <li><a href="{{ URL('article_list/'.$menu['tag_id']) }}">{{$menu['name']}}<span class="sr-only"></span></a></li>
           @endforeach
           <!-- <li><a href="#">生活</a></li> -->
            <!--  <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">生活
                 <span class="caret"></span>
               </a>
               <ul class="dropdown-menu">
                 <li><a href="#">生活</a></li>
                 <li role="separator" class="divider"></li>
                 <li><a href="#">生活</a></li>
                 <li role="separator" class="divider"></li>
                 <li><a href="#">生活</a></li>
               </ul>
             </li> -->
           </ul>
           <form action="{{ URL('article_search') }}" method="POST" class="navbar-form navbar-left" role="search">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <div class="form-group">
             <input type="text" name="content" class="form-control" placeholder="i want mac pro 15" value="{{$search or ''}}">
             </div>
             <button type="submit" class="btn btn-default">GO</button>
           </form>
         </div><!-- /.navbar-collapse -->
       </div><!-- /.container-fluid -->
     </nav>
   </div>
 </div>
 <!-- nav -->
 @yield('content')
 <div class="container">
   <div id="footer" style="text-align: center; margin: 50px 0 0; padding: 40px;">
     <div id="link">
       <span>友情链接：</span>
       @foreach ($love_links as $love_link)
       <a target="_blank" href="{{$love_link['extra']}}">{{$love_link['name']}}</a>
       @endforeach
     </div>
     ©2016.06-{!! date('Y.m') !!}<a href="./" class="xl">Xl</a>
   </div>
 </div>
</body>
</html>
