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
