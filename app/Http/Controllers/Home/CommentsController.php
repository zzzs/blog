<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Redirect, Input;

use App\Models\Comment;
use App\Libs\Consts\Error;
class CommentsController extends Controller {

	public function store()
	{
		if (Comment::create(Input::all())) {
			$this->jsonResponse('',Error::COMMENT_PUBLISH_SUCCESS,0);
		} else {
			$this->jsonResponse('',Error::COMMENT_PUBLISH_ERROR,1);
		}
	}

}
