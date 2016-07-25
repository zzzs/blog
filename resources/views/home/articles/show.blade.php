@extends('_layouts.default')

@section('content')
  <link href="{{ asset('/css/home/article.css') }}" rel="stylesheet">

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
      <hr>

      <!-- 评论 -->
      <div id="comments">
        <h3>评论</h3>

        <!-- 发表评论 -->
        <div class="modal fade bs-example-modal-lg" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" data-backdrop="false">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 style="text-align: center;" class="modal-title" id="commentModalLabel">I WANT YOU</h4>
              </div>
              <div class="modal-body" class="md-body">

                <form id="comment-form" class="form-horizontal" action="{{ URL('comment/store') }}" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                  <input type="hidden" name="pid" value="0">
                  <div class="form-group">
                    <label class="col-sm-1 control-label">昵称</label>
                    <div class="col-sm-11">
                      <input type="text" name="nickname" class="form-control" placeholder="你的昵称" required="required">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-1 control-label">邮箱</label>
                    <div class="col-sm-11">
                      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="你的邮箱">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-1 control-label">主页</label>
                    <div class="col-sm-11">
                      <input type="website" name="website" class="form-control" id="inputEmail3" placeholder="你的个人主页">
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

  <script>
    $(".reply a").click(function(){
      $('#commentModal').modal('show');
    });
    $('#commentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var modal = $(this);
      modal.find("#comment-form input[name='nickname']").val('');
      modal.find("#comment-form input[name='email']").val('');
      modal.find("#comment-form input[name='website']").val('');
      modal.find("#comment-form textarea[name='content']").attr('data-tonick','').val('');
      if (button.parent().attr("id") != 'publish') {
        var nickname = button.data('nickname');
        var comid = button.data('comid');
        modal.find("#comment-form textarea[name='content']").attr('data-tonick',nickname);
        modal.find("#comment-form input[name='pid']").val(comid);
      }else{
        modal.find("#comment-form input[name='pid']").val(0);
      }
    });

    $("#submit_but").click(function(){
      var com_form = $("#comment-form");
      var tonick = com_form.find("textarea[name='content']").attr('data-tonick');
      if (tonick != '') {
        var comment = com_form.find("textarea[name='content']").val();
        com_form.find("textarea[name='content']").val('@'+tonick+'：'+comment);
      }
      $('.modal-header button span').click();
      $.ajax({
        type: "POST",
        url: com_form.attr( 'action' ),
        data: com_form.serialize(),
        success: function( ret ) {
          if (ret.status == 1) {
            success_confirm(ret.msg,3000);
          }else{
            error_confirm(ret.msg,3000);
          }
        }
      });
    });

    //评论
    var contents = {!! $article->Comments !!};
    $.each(contents, function( index, value ) {
      createContentElement('comments',value);
    });

  </script>
@endsection
