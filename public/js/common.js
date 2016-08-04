  /**
   * 创建评论dom
   * @param  {[type]} comments_id  [description]
   * @param  {[type]} comment_data [description]
   * @return {[type]}              [description]
   */
  function createContentElement(comments_id,comment_data){
  	var nickname_str,content_str;
  	if (comment_data.website != null) {
  		nickname_str = "<h3><a href='"
  		+comment_data.website
  		+"' target='_blank'>"
  		+comment_data.nickname
  		+"</a></h3>";
  	}else{
  		nickname_str = "<h3>"
  		+comment_data.nickname
  		+"</h3>";
  	}

  	content_str = "<div class='nickname'>"
  	+nickname_str
  	+"<h6>"
  	+comment_data.created_at
  	+"</h6></div>";
  	content_str += "<div class='content'><p>"
  	+comment_data.content
  	+"</p></div><div class='reply'><a data-toggle='modal' data-target='#commentModal' data-nickname='"
  	+comment_data.nickname
  	+"' data-comid='"
  	+comment_data.comment_id
  	+"'>回复</a></div>";

  	var comment_item,comment_wait_class='';
    //第一级
    if (comment_data.status == 0) {
      comment_wait_class ='comment_wait';
    }
    if (comment_data.pid == 0){
    	comment_item = "<div id='con-"
    	+comment_data.comment_id
    	+"' class='article-con "
      +comment_wait_class
      +"'>"
      +content_str
      +"</div>";

      $('#'+comments_id).append(comment_item);
    }else{
    	comment_item = "<div id='con-"
    	+comment_data.comment_id
    	+"' class='article-con article-con-child "
      +comment_wait_class
      +"'>"
      +content_str
      +"</div>";
      if($('#con-'+comment_data.pid).length>0){
       $('#con-'+comment_data.pid).append(comment_item);
     }
   }
 }



 $('.modal').on('hide.bs.modal', function (event) {
  $(this).find(".modal-title").empty();
  $(this).find(".modal-body").empty();
});
