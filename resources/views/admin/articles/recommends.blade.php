@extends('_layouts.adminbase')

@section('content')
<link href="{{ asset('/css/admin/articles.css') }}" rel="stylesheet">
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">推荐文章
        <button id="addrecommend" type="button" class="btn btn-xs btn-success" data-cateid="{{$article->cate_id}}" data-toggle="modal" data-target="#addrecommendModal">添加</button>
      </div>

      <!-- 推荐 -->
      <div class="panel-body md-body">
        <h3>推荐</h3>
        <hr>
        <table class="table table-striped" id="recom-table" style="table-layout:fixed">
          <tr class="row">
            <th class="col-lg-1">文章ID</th>
            <th class="col-lg-6">标题</th>
            <th class="col-lg-3">内容</th>
            <th class="col-lg-1">查看</th>
            <th class="col-lg-1">删除</th>
          </tr>
          @foreach ($article->recommends as $recommend)
          <tr class="row" id="recom-{{$recommend->pivot->recommend_id}}">
            <td class="col-lg-1">
              {{ $recommend->article_id }}
            </td>
            <td class="col-lg-6 recommend-title">
              {{ $recommend->title }}
            </td>
            <td class="col-lg-3">
              {{ $recommend->body }}
            </td>
            <td class="col-lg-1">
              <button type="button" class="btn btn-xs btn-primary read_recommend" data-toggle="modal" data-target="#readModal">查看</button>
              <input type="hidden" value="{{$recommend->html_body}}">
            </td>
            <td class="col-lg-1">
              <button type="button" data-recomid="{{ $recommend->pivot->recommend_id }}" class="btn btn-xs btn-danger del-recommend">删除</button>
            </td>
          </tr>
          @endforeach
        </table>

        <!-- addrecommendModal -->
        <div class="modal fade bs-example-modal-lg" id="addrecommendModal" tabindex="-1" role="dialog" aria-labelledby="addrecommendModalLabel" data-backdrop="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <form class="form-inline">
                  <div class="form-group">
                    <label class="sr-only">标题</label>
                    <input type="text" name="title" value="" class="form-control" placeholder="标题">
                  </div>
                  <input type="hidden" name="cate" value="" class="form-control">
                  <a class="btn btn-default submit">查找</a>
                </form>
              </div>
              <div class="modal-body md-body">
                <table class="table table-striped" style="table-layout:fixed;margin-bottom:0;">
                  <tr class="row">
                    <th class="col-lg-1">文章ID</th>
                    <th class="col-lg-9">标题</th>
                    <th class="col-lg-1">查看</th>
                    <th class="col-lg-1">添加</th>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
              </div>
            </div>
          </div>
        </div>
        <!-- addrecommendModal -->

        <!-- readModal -->
        <div class="modal fade bs-example-modal-lg" id="readModal" tabindex="-1" role="dialog" aria-labelledby="readModalLabel" data-backdrop="false">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="readModalLabel"></h4>
              </div>
              <div class="modal-body md-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" id="modal-del-recommend" class="btn btn-danger">删除</button>
              </div>
            </div>
          </div>
        </div>
        <!-- readModal -->

        <!-- readrecommendModal -->
        <div class="modal fade bs-example-modal-lg" id="readrecommendModal" tabindex="-1" role="dialog" aria-labelledby="readrecommendModalLabel" data-backdrop="false">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="readrecommendModalLabel"></h4>
              </div>
              <div class="modal-body md-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" id="modal-add-recommend" class="btn btn-danger">添加</button>
              </div>
            </div>
          </div>
        </div>
        <!-- readrecommendModal -->

      </div>
      <!-- 推荐 -->

      <!-- 文章 -->
      <div class="panel-body" id="comment-article">
        <hr>
        <center>  <h3>{{$article->title}}</h3>  </center>
        <div class=" md-body">
          {!! $article->html_body !!}
        </div>
      </div>
      <!-- 文章 -->

    </div>
  </div>
</div>

<script>
  var self_article_id = {!!$article->article_id!!};
  // var recommends = {!! $article->recommends !!};
  //未被推荐的文章
  var notrecommends;
  var _token = "{{ csrf_token() }}";
  /* addrecommendModal */
  $('#addrecommendModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    $(this).find("form input[name='cate']").val(button.data('cateid'));
    $(this).find("form a.submit").click();
  });
  //查询
  $("#addrecommendModal").find("form a.submit").click(function(){
    var form_data = $("#addrecommendModal").find('form').serialize();
    var geturl = "{{ URL('admin/articles/notrecommend/') }}/"+self_article_id+"?"+form_data;
    $.get(geturl,function(ret){
      var article_table = $("#addrecommendModal").find('table');
      var article_tr = article_table.find('tr').eq(0);
      article_table.find('tr').remove();
      article_table.append(article_tr);
      notrecommends = ret.data;

      var article_item;
      $.each(notrecommends, function( index, value ) {
        article_item = "<tr class='row' id='recom-art-"
        +value.article_id
        +"'><td class='col-lg-1 recom_art_id'>"
        +value.article_id
        +"</td><td class='col-lg-9 recommend-title'>"
        +value.title
        +"</td><td class='col-lg-1'>"
        +"<button type='button' class='btn btn-xs btn-primary read_recommend' data-toggle='modal' data-target='#readrecommendModal'>查看</button>"
        +"<input type='hidden' value='"
        +value.html_body
        +"'></td><td class='col-lg-1'>"
        +"<a class='btn btn-xs btn-info add_recom_art'>添加</a>"
        +"</td></tr>";
        article_table.append(article_item);
      });

      //点击查看为推荐的文章
      $('.read_recommend').click(function(){
        var art_body = $(this).siblings('input').val();
        var art_title = $(this).parent().siblings('.recommend-title').text();
        $("h4#readrecommendModalLabel").text(art_title);
        $("#readrecommendModal .modal-body").html(art_body);
        var recomid = $(this).parent().siblings('.recom_art_id').text();
        $("#readrecommendModal #modal-add-recommend").attr('data-recomid',recomid);
      });

      //点击添加
      $('.add_recom_art').click(function(){
        //在第几行
        var recom_index = this.parentNode.parentNode.rowIndex-1;
        var recom_art_id = $(this).parent().siblings('.recom_art_id').text();
        // var recom_art_id = $(this).attr('data-recomid');
        $.post("{{ URL('admin/recommends') }}",{
          article_id:self_article_id,
          re_article_id:recom_art_id,
          _token:_token
        },function(ret){
          if (ret.status == 0) {
            if($("#readrecommendModal").length>0){
              $("#readrecommendModal").modal('hide');
            }
            $("#recom-art-"+recom_art_id).fadeTo("slow", 0.05,function(){
              $("#recom-art-"+recom_art_id).slideUp("fast", function(){
                $("#recom-art-"+recom_art_id).remove();
              });
            });

            var recom_art_item = "<tr class='row' id='recom-"
            +ret.data.recommend_id
            +"'><td class='col-lg-1'>"
            +notrecommends[recom_index].article_id
            +"</td><td class='col-lg-6 recommend-title'>"
            +notrecommends[recom_index].title
            +"</td><td class='col-lg-3'>"
            +notrecommends[recom_index].body
            +"</td><td class='col-lg-1'><button type='button' class='btn btn-xs btn-primary read_recommend' data-toggle='modal' data-target='#readModal'>查看</button><input type='hidden' value='"
            +notrecommends[recom_index].html_body
            +"'></td><td class='col-lg-1'><button type='button' data-recomid='"
            +ret.data.recommend_id
            +"' class='btn btn-xs btn-danger del-recommend'>删除</button></td></tr>";

            $('#recom-table').append(recom_art_item);
          }else{
            error_confirm(ret.msg,3000);
          }
        });
      });

    });
  });
  //添加推荐
  // $('button.add_recom_art').click(function(){
  //   console.log(111);
  //   var recom_art_id = $(this).parent().siblings('.recom_art_id').html();
  //   console.log(recom_art_id);
  //       console.log($(this).parent().siblings('.recom_art_id'));

  // });

  /* addrecommendModal */

  /* addrecommendModal */

  /* read-recommend */
  //点击查看
  $('.read_recommend').click(function(){
    var art_body = $(this).siblings('input').val();
    var art_title = $(this).parent().siblings('.recommend-title').text();
    $("h4#readModalLabel").text(art_title);
    $("#readModal .modal-body").html(art_body);
    var recomid = $(this).parent().parent().attr('id');
    $("#readModal #modal-del-recommend").attr('data-recomid',recomid);
  });
  /* read-recommend */

  /* del-recommend */
  var recomid;
  $('button.del-recommend').click(function(){
    recomid = $(this).data('recomid');
  });
  $('.del-recommend').confirm({
    title: 'ARE YOU SURE ?',
    content: false,
    theme: 'green',
    closeIcon: true,
    confirm: function(){
      $.post("{{ URL('admin/recommends/') }}/"+recomid,{
        _method:'DELETE',
        _token:_token
      },function(ret){
        if (ret.status == 0) {
          if($("#readModal").length>0){
            $("#readModal").modal('hide');
          }
          $("#recom-"+recomid).fadeTo("slow", 0.05,function(){
            $("#recom-"+recomid).slideUp("fast", function(){
              $("#recom-"+recomid).remove();
            });
          });
        }else{
          error_confirm(ret.msg,3000);
        }
      });
    }
  });

  $("#modal-del-recommend").click(function(){
    var recommend_id= $(this).attr('data-recomid');
    $("table tr#"+recommend_id).find('.del-recommend').click();
  });
  /* del-recommend */


</script>
@endsection

