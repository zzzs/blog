@extends('_layouts.homebase')

@section('content')
<!-- <link href="{{ asset('/css/home/article.css') }}" rel="stylesheet"> -->

<div id="content" class="container">
  <div class="con_item" id="article_show">
    <!--  style="margin: 0 auto;" -->
    <div class="title">
      <a href="{{ URL('articles/'.$article['article_id']) }}">
        <h2 style="margin-top:0;margin-bottom:40px;">{{ $article['title'] }}</h2>
      </a>
    </div>
    <hr>
    <div class="con_body md-body">
      {!! $article->html_body !!}
    </div>
    @if (count($article['recommends']) !== 0)
    <hr>
    <h3>推荐文章</h3>
    <div class="recommend">
      @foreach ($article->recommends as $item)
      <a href="{{ URL('articles/'.$item->article_id) }}">{{$item->title}}</a>
      @endforeach
    </div>
    @endif
    <hr>
    <!-- 前后页 -->
    @if (!empty($prew))
    <a class="arrow art_prew" title="上一篇" href="{{ URL('articles/'.$prew->article_id) }}">{{$prew->title}}</a>
    @endif
    @if (!empty($next))
    <a class="arrow art_next" title="下一篇" href="{{ URL('articles/'.$next->article_id) }}">{{$next->title}}</a>
    @endif

    <hr style="clear:both;">
    <!-- 评论 -->
    <div id="comments">
      <h3>相关评论</h3>

      <!-- 发表评论 -->
      <div class="modal fade bs-example-modal-lg" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 style="text-align: center;" class="modal-title">I WANT YOU</h4>
            </div>
            <div class="modal-body" class="md-body">

              <form id="comment-form" class="form-horizontal" action="{{ URL('comment/store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                <input type="hidden" name="pid" value="0">
                <div class="form-group">
                  <label class="col-sm-1 control-label">昵称</label>
                  <div class="col-sm-11">
                    <input type="text" name="nickname" class="form-control" placeholder="你的昵称" value="{{ $guest['nickname'] }}" required="required">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-1 control-label"">邮箱</label>
                  <div class="col-sm-11">
                    <input type="email" name="email" class="form-control" value="{{ $guest['email'] }}" id="inputEmail3" placeholder="你的邮箱">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-1 control-label">主页</label>
                  <div class="col-sm-11">
                    <input type="website" name="website" value="{{ $guest['website'] }}" class="form-control" id="inputEmail3" placeholder="你的个人主页">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-1 control-label">吐槽</label>
                  <div class="col-sm-11">
                    <textarea name="content" placeholder="吐槽" class="form-control" rows="3" required="required"></textarea>
                  </div>
                </div>
              </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              <button id="submit_but" type="button" class="btn">提交</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="publish">
      <a data-toggle="modal" data-target="#commentModal">评论</a>
    </div>

    <!-- 发表评论 -->
  </div>
</div>

@include('template.comment')

<script>
  var article = {!! $article !!};
  var contents = article.comments;
  var commentTemplate, commentHtml;
  $.each(contents, function( index, value ) {

    commentTemplate = _.template($('#comment-template').html());
    commentHtml = commentTemplate(value);

    if (value.pid == 0){
      $('#comments').append(commentHtml);
    }else{
      if($('#con-'+value.pid).length>0){
        $('#con-'+value.pid).append(commentHtml);
      }
    }
  });


  /***************article.show***************/
  $('#commentModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    modal.find("#comment-form textarea[name='content']").attr('data-tonick','').val('');
    if (button.parent().attr("id") != 'publish') {
      var comid = button.data('comid');
      modal.find("#comment-form input[name='pid']").val(comid);
    }else{
      modal.find("#comment-form input[name='pid']").val(0);
    }
  });

  $("#submit_but").click(function(){
    var com_form = $("#comment-form");

    var emailDom = com_form.find("input[name='email']");
    var email=$.trim(emailDom.val());
    if(email != '' && !email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
    {
      error_confirm('邮箱格式不正确！',1000);
      emailDom.focus();
      return false;
    }

    var contentDom = com_form.find("textarea[name='content']");
    var content = $.trim(contentDom.val());
    if (content == '') {
      error_confirm('你还没吐槽哦！',1000);
      contentDom.focus();
      return false;
    }


    $('.modal-header button span').click();
    $.ajax({
      type: "POST",
      url: com_form.attr( 'action' ),
      data: com_form.serialize(),
      success: function( ret ) {
        if (ret.status == 1) {
          error_confirm(ret.msg,3000);
        }else{
          success_confirm(ret.msg,3000);
        }
      }
    });
  });

  $('.article-con').eq(0).css("border-top","solid 10px #00B38C");
  /***************article.show***************/

</script>

<script src="{{ asset('/js/home/articles.js') }}"></script>

@endsection
