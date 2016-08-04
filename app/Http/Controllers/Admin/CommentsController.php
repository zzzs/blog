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
			$this->jsonResponse($ret->toArray());
		} else {
			$this->jsonResponse('',Error::COMMENT_PUBLISH_ERROR,1);
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
			$this->jsonResponse('',$msg,1);
		}else{
			$comment->delete();
			$this->jsonResponse('');
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
			$this->jsonResponse('',Error::NOT_EXIST_RECODE,1);
		}
		$data = Input::except(['_method', '_token']);
		if ($comment->update($data)) {
			$this->jsonResponse('');
		} else {
			$this->jsonResponse('',Error::UPDATE_ERROR,1);
		}
	}
}
