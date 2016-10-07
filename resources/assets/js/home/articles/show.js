 /***************article.show***************/
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
 			if (ret.status == 0) {
 				error_confirm(ret.msg,3000);
 			}else{
 				success_confirm(ret.msg,3000);
 			}
 		}
 	});
 });

//评论
var contents = article.comments;
$.each(contents, function( index, value ) {
	createContentElement('comments',value);
});

$('.article-con').eq(0).css("border-top","solid 10px #00B38C");
/***************article.show***************/
