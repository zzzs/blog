/*========== comments ==========*/

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
/*========== comments ==========*/
