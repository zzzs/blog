@extends('admin.app')

@section('content')

  <style type="text/css">
    @font-face {
      font-family: digit;
      src: url('digital-7_mono.ttf') format("truetype");
    }
  </style>
  <link href="{{ asset('/love/love.css') }}" rel="stylesheet">
  <script type="text/javascript" src="{{ asset('/love/garden.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/love/functions.js') }}"></script>

  <div id="mainDiv">
    <div id="content">
      <div id="code">
        <span class="comments">/**</span><br />
        <span class="space"/><span class="comments">* 2014-11-04</span><br />
        <span class="space"/><span class="comments">*/</span><br />
        Boy name = <span class="keyword">Mr</span> ZHANG<br />
        Girl name = <span class="keyword">Mrs</span> JIANG<br />
        <span class="comments">// Fall in love river. </span><br />
        The boy love the girl;<br />
        <span class="comments">// They love each other.</span><br />
        The girl loved the boy;<br />
        <span class="comments">// AS time goes on.</span><br />
        The boy can not be separated the girl;<br />
        <span class="comments">// At the same time.</span><br />
        The girl can not be separated the boy;<br />
        <span class="comments">// Both wind and snow all over the sky.</span><br />
        <span class="comments">// Whether on foot or 5 kilometers.</span><br />
        <span class="keyword">The boy</span> very <span class="keyword">happy</span>;<br />
        <span class="keyword">The girl</span> is also very <span class="keyword">happy</span>;<br />
        <span class="placeholder"/><span class="comments">// Whether it is right now</span><br />
        <span class="placeholder"/><span class="comments">// Still in the distant future.</span><br />
        <span class="placeholder"/>The boy has but one dream;<br />
        <span class="comments">// The boy wants the girl could well have been happy.</span><br />
        <br>
        <br>
        I want to say:<br />
        Baby, I love you forever;<br />
      </div>
      <div id="loveHeart">
        <canvas id="garden"></canvas>
        <div id="words">
          <div id="messages">
            亲爱的，这是我们相爱在一起的时光。
            <div id="elapseClock"></div>
          </div>
          <div id="loveu">
            爱你直到永永远远。<br/>
            <div class="signature">- 章先生</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var offsetX = $("#loveHeart").width() / 2;
    var offsetY = $("#loveHeart").height() / 2 - 55;
    var together = new Date();
    together.setFullYear(2014, 11, 04);
    together.setHours(20);
    together.setMinutes(0);
    together.setSeconds(0);
    together.setMilliseconds(0);

    if (!document.createElement('canvas').getContext) {
      var msg = document.createElement("div");
      msg.id = "errorMsg";
      msg.innerHTML = "Your browser doesn't support HTML5!<br/>Recommend use Chrome 14+/IE 9+/Firefox 7+/Safari 4+";
      document.body.appendChild(msg);
      $("#code").css("display", "none")
      $("#copyright").css("position", "absolute");
      $("#copyright").css("bottom", "10px");
      document.execCommand("stop");
    } else {
      setTimeout(function () {
        startHeartAnimation();
      }, 5000);//隔5000ms后执行startHeartAnimation（）

      timeElapse(together);
      setInterval(function () {
        timeElapse(together);
      }, 500);

      adjustCodePosition();
      $("#code").typewriter();
    }
  </script>
<!-- <div style="text-align:center;clear:both">
<p>适用浏览器：360、FireFox、Chrome、Safari、Opera、傲游、搜狗、世界之窗. 不支持IE8及以下浏览器。</p>
<p>来源：<a href="http://sc.chinaz.com/" target="_blank">站长素材</a></p>
</div> -->
@endsection
