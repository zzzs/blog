<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Recommend;
use App\Models\Article;
use App\Libs\Consts\Error;
use Redirect, Input;

class RecommendsController extends Controller {

	public function store()
	{
		if ($ret = Recommend::create(Input::except(['_token']))) {
			$this->jsonResponse($ret->toArray());
		} else {
			$this->jsonResponse('',Error::ADD_ERROR,1);
		}
	}

	/**
	 * 删除评论
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function destroy($id)
	{
		$comment = Recommend::find($id);
		$ret = $comment->delete();
		if (empty($ret)) {
			$this->jsonResponse('',Error::DEL_ERROR,1);
		}
		$this->jsonResponse('');
	}

}
