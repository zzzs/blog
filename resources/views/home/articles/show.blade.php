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
                    <label for="inputPassword3" name="email" class="col-sm-1 control-label">邮箱</label>
                    <div class="col-sm-11">
                      <input type="email" class="form-control" id="inputEmail3" placeholder="你的邮箱">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" name="website" class="col-sm-1 control-label">主页</label>
                    <div class="col-sm-11">
                      <input type="website" class="form-control" id="inputEmail3" placeholder="你的个人主页">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-1 control-label">吐槽</label>
                    <div class="col-sm-11">
                      <textarea name="content" placeholder="吐槽" class="form-control" rows="3" required="required"></textarea>
                    </div>
                  </div>
                  <div class="form-group" style="display:none">
                    <div class="col-sm-offset-1 col-sm-10">
                      <button type="submit" class="btn btn-default">Do</button>
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
    $('#commentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      if (button.parent().attr("id") != 'publish') {
        var nickname = button.data('nickname');
        var comid = button.data('comid');
        var modal = $(this);
        modal.find("#comment-form textarea[name='content']").val('@'+nickname+'：');
        modal.find("#comment-form input[name='pid']").val(comid);
      }
    });
    $("#submit_but").click(function(){
      $("form button[type='submit']").click();
    });

    var contents = <?php echo $article->comments; ?>;
    $.each(contents, function( index, value ) {
      createContentElement('comments',value);
    });

  </script>
@endsection
