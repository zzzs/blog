@extends('admin.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">编辑 文章</div>

      <div class="panel-body">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Whoops!</strong> There were some problems with your input.<br><br>
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ URL('admin/articles/'.$article->article_id) }}" method="POST" class="form-horizontal">
          <input name="_method" type="hidden" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form-group">
            <label class="col-sm-2 control-label">标题</label>
            <div class="col-sm-10">
              <input type="text" name="title" class="form-control" required="required" value="{{ $article->title }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">分类</label>
            <div class="col-sm-10">
              <select class="form-control" name="cate">
                @foreach ($cates as $cate)
                @if ($cate->tag_id == $article->cate_id)
                <option value="{{ $cate->tag_id }}" selected="selected">{{ $cate->name }}</option>
                @else
                <option value="{{ $cate->tag_id }}">{{ $cate->name }}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10">
              <div class="btn-group" role="group" aria-label="..." id="md-but">
                <button id="icon-bold" type="button" title="加粗(Ctrl+B)" class="btn btn-default" data-hotkey="66"><i class="glyphicon glyphicon-bold"></i></button>
                <button id="icon-italic"type="button" title="斜体(Ctrl+I)" class="btn btn-default" data-hotkey="73"><i class="glyphicon glyphicon-italic"></i></button>
                <button id="icon-header" type="button" title="标题(Ctrl+H)" class="btn btn-default" data-hotkey="72"><i class="glyphicon glyphicon-header"></i></button>
                <button id="icon-link" type="button" title="链接(Ctrl+L)" class="btn btn-default" data-hotkey="76"><i class="glyphicon glyphicon-link"></i></button>

                <div class="btn-group" role="group">
                  <button  style="border-top-left-radius: 0;" type="button" title="图片(Ctrl+G)" class="btn btn-default dropdown-toggle" aria-expanded="false" data-hotkey="71" data-toggle="dropdown" aria-haspopup="true">
                    <i class="glyphicon glyphicon-picture"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a id="but_local_pic">本地图片</a></li>
                    <li><a id="but_online_pic">在线图片</a></li>
                  </ul>
                </div>

                <button id="icon-list" type="button" title="无序列表(Ctrl+U)" class="btn btn-default" data-hotkey="85"><i class="glyphicon glyphicon-list"></i></button>
                <button id="icon-th-list" type="button" title="有序列表(Ctrl+O)" class="btn btn-default" data-hotkey="79"><i class="glyphicon glyphicon-th-list"></i></button>
                <button id="icon-wrench" type="button" title="代码(Ctrl+K)" class="btn btn-default" data-hotkey="75"><i class="glyphicon glyphicon-wrench"></i></button>
                <button id="icon-comment" type="button" title="引用(Ctrl+Q)" class="btn btn-default" data-hotkey="81"><i class="glyphicon glyphicon-comment"></i></button>
                <button id="icon-open" type="button" title="上传(Ctrl+F)" class="btn btn-default" data-hotkey="70"><i class="glyphicon glyphicon-open"></i></button>
                <!-- <button id="icon-download-alt" type="button" title="下载(Ctrl+D)" class="btn btn-default" data-hotkey="68"><i class="glyphicon glyphicon-download-alt"></i></button> -->
                <button id="icon-remove" type="button" title="清空(Ctrl+M)" class="btn btn-default" data-hotkey="77"><i class="glyphicon glyphicon-remove"></i></button>
                <button data-toggle="modal" data-target="#helpModal" id="icon-question-sign" type="button" title="帮助" class="btn btn-default"><i class="glyphicon glyphicon-question-sign"></i></button>
              </div>
              <textarea id="art_body" name="body" rows="10" class="form-control" required="required">{{ $article->body }}</textarea>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button id="preview_art" type="button" class="btn btn-primary" data-toggle="modal" data-target="#previewModal">预览</button>
              <button class="btn btn-success" type="submit" class="btn btn-success">编辑</button>
            </div>
          </div>
        </form>
        <!-- OPEN MD FORM -->
        <form type="hidden" enctype="multipart/form-data" method="post" id="openfileform">
          <input style="display:none" id="openfile" type="file" name="mdfile" multiple="multiple"/>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <!-- OPEN MD FORM -->

        <!-- PIC LINK FORM -->
        <form type="hidden" enctype="multipart/form-data" method="post" id="openpicform">
          <input style="display:none" id="openpic" type="file" name="pic" multiple="multiple"/>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <!-- PIC LINK FORM -->

        <!-- dialog -->
        <!-- previewModal -->
        <div class="modal fade bs-example-modal-lg" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" data-backdrop="false">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 style="text-align: center;" class="modal-title" id="previewModalLabel">Modal title</h4>
              </div>
              <div class="modal-body md-body">
                mei dong xi yu lan ge sha
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button id="edit_but" type="button" class="btn btn-success">编辑</button>
              </div>
            </div>
          </div>
        </div>
        <!-- previewModal -->

        <!-- helpModal -->
        <div class="modal fade bs-example-modal-lg" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" data-backdrop="false">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 style="text-align: center;" class="modal-title" id="helpModalLabel">帮助</h4>
              </div>
              <div class="modal-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-bold"></i>
                    <span>**粗体**</span>
                    <span class="badge">Ctrl+B</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-italic"></i>
                    <span>_斜体_</span>
                    <span class="badge">Ctrl+I</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-header"></i>
                    <span>### 标题</span>
                    <span class="badge">Ctrl+H</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-link"></i>
                    <span>[输入链接说明](http://)</span>
                    <span class="badge">Ctrl+L</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-picture"></i>
                    <span>图片</span>
                    <span class="badge">Ctrl+G</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-list"></i>
                    <span>- 这里是列表文本</span>
                    <span class="badge">Ctrl+U</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span>1. 这里是列表文本</span>
                    <span class="badge">Ctrl+O</span>
                  </li>
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-wrench"></i>
                    <span>```
                      这里输入代码
                      ```</span>
                      <span class="badge">Ctrl+K</span>
                    </li>
                    <li class="list-group-item">
                      <i class="glyphicon glyphicon-comment"></i>
                      <span>> 这里输入引用文本</span>
                      <span class="badge">Ctrl+Q</span>
                    </li>
                    <li class="list-group-item">
                      <i class="glyphicon glyphicon-open"></i>
                      <span>上传</span>
                      <span class="badge">Ctrl+F</span>
                    </li><!--
                    <li class="list-group-item">
                      <i class="glyphicon glyphicon-download-alt"></i>
                      <span>下载</span>
                      <span class="badge">Ctrl+D</span>
                    </li> -->
                    <li class="list-group-item">
                      <i class="glyphicon glyphicon-remove"></i>
                      <span>清空</span>
                      <span class="badge">Ctrl+M</span>
                    </li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
              </div>
            </div>
          </div>
          <!-- helpModal -->
          <!-- dialog -->
        </div>
      </div>
    </div>
  </div>

<script>

  /*预览*/
  var _token = "{{ csrf_token() }}";
  $('#preview_art').click(function(){
    var art_body = $('textarea#art_body').val();
    var art_title = $("input[name='title']").val();
    $("h4#previewModalLabel").text(art_title);
    $.post("{{ URL('admin/common/preview') }}",{
      art_body:art_body,
      _token:_token
    },function(ret){
      $("#previewModal .modal-body").html(ret.html_body);
    });
  });

  $("#edit_but").click(function(){
    $("button[type='submit']").click();
  });
  /*预览*/

  /*富文本编辑*/
  $(document).keydown(function(e) {
    $('#md-but').find('button').each(function(){
      $key = $(this).data('hotkey');
      if ($key != undefined && e.ctrlKey && e.which == $key){
        $(this).click();
      }
    })
  });

  $("#md-but").find('button,a').click(function(){
    var but_id = $(this).attr('id');

    switch(but_id)
    {
      case 'icon-bold'://粗体
      var add_con = '**粗体**';
      var high_con = '粗体';
      break;

      case 'icon-italic'://斜体
      var add_con = '_斜体_';
      var high_con = '斜体';
      break;

      case 'icon-header'://标题
      var add_con = '\n### 标题';
      var high_con = '标题';
      break;

      case 'icon-link'://链接
      var add_con = '[输入链接说明](http://)';
      var high_con = '输入链接说明';
      break;

      case 'icon-list'://无序列表
      var add_con = '\n- 这里是列表文本';
      var high_con = '这里是列表文本';
      break;

      case 'icon-th-list'://有序列表
      var add_con = '\n1. 这里是列表文本';
      var high_con = '这里是列表文本';
      break;

      case 'icon-wrench'://代码
      var add_con = '\n```\n这里输入代码\n```';
      var high_con = '这里输入代码';
      break;

      case 'icon-comment'://引用
      var add_con = '\n> 这里输入引用文本';
      var high_con = '这里输入引用文本';
      break;

      case 'icon-open'://打开MD
      $("#openfile").click();
      return;

      case 'but_online_pic'://在线图片
      var add_con = '![图片替代文字](http://)';
      var high_con = 'http://';
      break;

      case 'but_local_pic'://本地图片
      $("#openpic").click();
      return;

      case 'icon-remove'://清空
      $("#art_body").val('');
      return;

      default:
      return;
    }
    //todo 光标位置显示
    var body_con = $("#art_body").val();
    $("#art_body").val(body_con+add_con);
    var art_body = document.getElementById('art_body');
    num = add_con.indexOf(high_con);
    start = body_con.length+num;
    end = start + high_con.length;
    art_body.selectionStart = start;
    art_body.selectionEnd=end;
  });

  /*图片链接*/
  $("#openpic").change(function(){
    var data = new FormData(document.getElementById("openpicform"));
    $.ajax({
      url:"{{ URL('admin/common/upload_pic') }}",
      type:'POST',
      data:data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(ret){
        if (ret.status == 0) {
          var body_con = $("#art_body").val();
          $("#art_body").val(body_con+'![图片替代文字]('+ret.data+')');
        }else{
          error_confirm(ret.msg);
        }
      },
      error:function(){
        error_confirm('上传出错');
      }
    });
    $(this).val("");//必须
  });

  /*打开MD*/
  $("#openfile").change(function(){
    var data = new FormData(document.getElementById("openfileform"));
    $.ajax({
      url:"{{ URL('admin/common/load_md') }}",
      type:'POST',
      data:data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(ret){
        if (ret.status == 0) {
          var body_con = $("#art_body").val();
          $("#art_body").val(body_con+'\n'+ret.data);
        }else{
          error_confirm(ret.msg);
        }
      },
      error:function(){
        error_confirm('上传出错');
      }
    });
    $(this).val("");
  });

  /*富文本编辑*/

</script>
@endsection
