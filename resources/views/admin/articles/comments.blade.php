@extends('admin.app')

@section('content')
<link href="{{ asset('/css/admin/article.css') }}" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">管理评论<a href="#comment-article" class="btn btn-xs btn-primary">文章</a></div>
      <div class="panel-body md-body">

        <!-- 评论 -->
        <div id="comments">
          <h3>评论</h3>

        </div>
      </div>
      <hr>

      <div class="panel-body" id="comment-article">
        <center>  <h3>{{$article->title}}</h3>  </center>
        <div class=" md-body">
          {!! $article->html_body !!}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 发表评论 -->
<div class="modal fade bs-example-modal-lg" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="text-align: center;" class="modal-title" id="commentModalLabel">I WANT YOU</h4>
      </div>
      <div class="modal-body" class="md-body">

        <form id="comment-form" class="form-horizontal" action="{{ URL('admin/comments') }}" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="article_id" value="{{ $article->article_id }}">
          <input type="hidden" name="pid" value="0">
          <input type="hidden" name="status" value="1">
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
<script>
  var contents = {!! $article->Comments !!};
  $.each(contents, function( index, value ) {
    createContentElement('comments',value);
  });

  $('.reply').append("<a class='del_com'>删除</a>");
  $('.comment_wait').find('.reply').append("<a class='check_com'>审核</a>");

  var comid;
  $('.reply a').click(function(){
    comid = $(this).siblings("a[data-toggle='modal']").data('comid');
  });

  var _token = "{{ csrf_token() }}";
  //删除评论
  $('.reply .del_com').confirm({
    title: 'ARE YOU SURE ?',
    content: false,
    theme: 'green',
    closeIcon: true,
    confirm: function(){
      $.post("{{ URL('admin/comments/') }}/"+comid,{
        _method:'DELETE',
        _token:_token
      },function(ret){
        if (ret.status == 0) {
          $("#con-"+comid).fadeTo("slow", 0.01,function(){
            $("#con-"+comid).slideUp("fast", function(){
              $("#con-"+comid).remove();
            });
          });
        }else{
          error_confirm(ret.msg,3000);
        }
      });
    }
  });

  //审核评论
  $('.reply .check_com').confirm({
    title: 'I THINK ...',
    content: false,
    theme: 'red',
    confirmButton: 'Congratulate',
    cancelButton: 'SORRY',
    closeIcon: true,
    confirm: function(){
      $.post("{{ URL('admin/comments/') }}/"+comid,{
        _method:'PUT',
        _token:_token,
        status:1
      },function(ret){
        if (ret.status == 0) {
          $("#con-"+comid).fadeOut("slow",function(){
            $("#con-"+comid).find('a.check_com').remove();
            $("#con-"+comid).removeClass('comment_wait').fadeIn(100);
          });
        }else{
          error_confirm(ret.msg,3000);
        }
      });
    },
    cancel: function(){
      $.post("{{ URL('admin/comments/') }}/"+comid,{
        _method:'PUT',
        _token:_token,
        status:2
      },function(ret){
        if (ret.status == 0) {
          $("#con-"+comid).fadeTo("slow", 0.01,function(){
            $("#con-"+comid).slideUp("fast", function(){
              $("#con-"+comid).remove();
            });
          });
        }else{
          error_confirm(ret.msg,3000);
        }
      });
    }
  });
  //回复评论
  $(".reply a[data-toggle='modal']").click(function(){
    if($(this).parent().parent().is('.comment_wait')) {
      error_confirm('先审核再回复',3000);
      $('#commentModal').modal('show');
      return;
    }
  });

  $('#commentModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    modal.find("#comment-form input[name='nickname']").val('').focus();
    modal.find("#comment-form input[name='email']").val('');
    modal.find("#comment-form input[name='website']").val('');

    var nickname = button.data('nickname');
    var comid = button.data('comid');
    modal.find("#comment-form textarea[name='content']").attr('data-tonick',nickname);
    modal.find("#comment-form input[name='pid']").val(comid);
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
        if (ret.status == 0) {
          createContentElement('comments',ret.data);
          $('#con-'+ret.data.comment_id).find('.reply').append("<a class='del_com'>删除</a>");
        }else{
          error_confirm(ret.msg,3000);
        }
      }
    });
  });

</script>
@endsection
