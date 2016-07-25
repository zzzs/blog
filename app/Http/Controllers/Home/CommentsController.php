<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CommonController;

use Illuminate\Http\Request;

use Redirect, Input;

use App\Models\Comment;
use App\Libs\Consts\Error;
class CommentsController extends CommonController {

	public function store()
	{
		if (Comment::create(Input::all())) {
			$this->json_return('',Error::COMMENT_PUBLISH_SUCCESS,1);
		} else {
			$this->json_return('',Error::COMMENT_PUBLISH_ERROR,0);
		}
	}

}
