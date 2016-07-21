<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\CommonController;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Article;
use App\Libs\Consts\Error;
use Redirect, Input;

class CommentsController extends CommonController {

	public function store()
	{
		if ($ret = Comment::create(Input::except(['_token']))) {
			$this->json_return($ret->toArray());
		} else {
			$this->json_return('',Error::COMMENT_PUBLISH_ERROR,0);
		}
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
			return Redirect::back()->withInput()->withErrors(Error::UPDATE_ERROR);
		}
	}

	/**
	 * 删除评论
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroy($id)
	{
		$comment = Comment::find($id);
		//判断若有人评论，则不准删
		if(count($comment->HasMe->toArray()) != 0){
			$msg = Error::COMMENT_HAS_CHILD;
			$this->json_return('',$msg,0);
		}else{
			$comment->delete();
			$this->json_return('');
		}
	}

	/**
	 * 审核评论
	 * @param  Request $request [description]
	 * @param  [type]  $id      [description]
	 * @return [type]           [description]
	 */
	public function check(Request $request, $id)
	{
		$this->validate($request, [
			'status' => 'required',
		]);
		$comment = Comment::find($id);
		if (empty($comment)) {
			$this->json_return('',Error::NOT_EXIST_RECODE,0);
		}
		$data = Input::except(['_method', '_token']);
		if ($comment->update($data)) {
			$this->json_return('');
		} else {
			$this->json_return('',Error::UPDATE_ERROR,0);
		}
	}
}
