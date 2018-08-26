<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Controllers\Home\BaseController;
use App\Libs\Enums\TagType;

class HomeController extends BaseController {

	//文章列表
	public function index(Request $request)
	{
		$articles = Article::select();

		if (!empty($request->title)) {
			$articles->where('title','like','%'.$request->title.'%');
		}
		if (!empty($request->cate)) {
			$articles->where('cate_id',$request->cate);
		}
		//默认分页
		if ($request->nopage) {
			$articles = $articles->get();
		}else{
			$limit = $request->input('limit',10);
			$articles = $articles->paginate($limit);
		}

		if ($request->ajax())
		{
	    	return $articles;
		}

		$base_data = $this->base_index();
		return view('home.home',['article_lists'=>$articles,'meta_desc'=>'我们俩永远在一起']+$base_data);
	}

}
