<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\CommonController;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Article;

use Redirect, Input;

class CommentsController extends CommonController {

	public function edit($id)
	{
		return view('admin.comments.edit')->withComment(Comment::find($id));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nickname' => 'required',
			'content' => 'required',
		]);
		if (Comment::where('id', $id)->update(Input::except(['_method', '_token']))) {
			return Redirect::to('admin/comments');
		} else {
			return Redirect::back()->withInput()->withErrors('更新失败！');
		}
	}

	public function destroy($id)
	{
		$comment = Comment::find($id);

		//判断若有人评论，则不准删
		if(count($comment->HasMe->toArray()) != 0){
			$msg = '删除失败！';
			$this->json_return('',$msg,1);
			// return Redirect::back()->withErrors('删除失败！');
		}else{
			$comment->delete();
			$this->json_return('');
		}


		// return Redirect::to('articles/comments/'.$comment->article_id);
	}

}
