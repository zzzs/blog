@extends('admin.app')

@section('content')
<link href="{{ asset('/css/admin/article.css') }}" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
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
            <?php echo $article->html_body ; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var contents = <?php echo $article->comments; ?>;
  $.each(contents, function( index, value ) {
    createContentElement('comments',value);
  });
  // $(".reply").each(function(){
  //   var comid = $(this).children('a').data('comid');
  //   $(this).append("<form action='{{ URL('admin/comments/'.$article->article_id) }}' method='POST' style='display: inline;'><input name='_method' type='hidden' value='DELETE'><input type='hidden' name='_token' value='{{ csrf_token() }}'><button type='submit' class='btn btn-xs btn-danger'>删除</button></form>");
  // });
  $('.reply').append("<a class='del_com'>删除</a>");

  $('.reply .del_com').confirm({
    title: 'Confirm!',
    content: 'Simple confirm!',
    theme: 'green',
    confirm: function(){
      var _token = "{{ csrf_token() }}";
      var comid = $(this).siblings('a').data('comid');
      console.log(aaa);
      $.post("{{ URL('admin/comments/') }}/"+comid,{
        _method:'DELETE',
        _token:_token
      },function(ret){
        console.log(ret);
        if (ret.status == 1) {
          alert(ret.msg);
          }else{//ok
            $("#con-"+comid).fadeTo("slow", 0.01,function(){
              $("#con-"+comid).slideUp("fast", function(){
                $("#con-"+comid).remove();
              });
            });
          }
        });
    }
  });


  /*
     $.confirm({
        title: 'Logout?',
        content: 'Your time is out, you will be automatically logged out in 10 seconds.',
        autoClose: 'confirm|10000',
        confirm: function(){
          alert('confirmed');
        },
        cancel:function(){
          alert('canceled');
        }
      });

   */


</script>
@endsection
