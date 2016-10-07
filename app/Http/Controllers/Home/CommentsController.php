<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Redirect, Input;

use App\Models\Comment;
use App\Models\Guest;
use App\Libs\Consts\Error;
use Validator;
class CommentsController extends Controller {

	public function store(Request $request)
	{
		$guest = new Guest();
		$input = Input::except(['_token']);

		$ip = $_SERVER['REMOTE_ADDR'];

		//信息重复
		$validate = Validator::make($input, [
			'nickname' => 'required|unique:guests,nickname,'. $ip .',ip',
			'email' => 'sometimes|email|unique:guests,email,'. $ip .',ip',
			'website' => 'sometimes|unique:guests,website,'. $ip .',ip'
			]);

		if ($validate->fails())
		{
			$this->jsonResponse('', $validate->errors()->first(), 1);
		}

		//访客数据更新
		$guestData = [
				'nickname' => $input['nickname'],
				'email' => $input['email'],
				'website' => $input['website'],
				'ip' => $ip
			];
		$ret = $guest::updateOrCreate(
			[
				'ip' => $ip
			],
			$guestData
		);

		//评论信息
		$comment = [
			'gid' => $ret->id,
			'article_id' => $input['article_id'],
			'pid' => $input['pid'],
			'content' => $input['content']
			];

		setcookie ("user", json_encode($guestData), time() + 30*86400, '/');

		//评论更新
		if (Comment::create($comment)) {
			$this->jsonResponse('', Error::COMMENT_PUBLISH_SUCCESS,0);
		} else {
			$this->jsonResponse('', Error::COMMENT_PUBLISH_ERROR,1);
		}
	}

}
