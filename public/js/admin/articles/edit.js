/*========== edit ==========*/
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

/*========== edit ==========*/
