<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class BaseController extends CommonController
{
	public function __construct()
	{
		$this->shareCookie();
	}

	public function base_index($where=[])
	{
		//搜索
		$search = (isset($where[0]) && $where[0]=='title')?str_replace('%', '', $where[2]):'';

		$uri=explode('/',\Route::current()->getUri());

		return [
			'action'=>$uri[0]
			];
	}

}
