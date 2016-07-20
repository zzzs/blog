<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Controllers\Home\BaseController;
use App\Libs\Enums\TagType;

class HomeController extends BaseController {

	public function index()
	{
		//文章
		$articles = Article::paginate(10);
		$base_data = $this->base_index();
		return view('Home.home',['article_lists'=>$articles]+$base_data);
	}

	/**
	 * xx类下的文章
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function articles($id)
	{
		$articles = Article::where('cate_id','=',$id)->get()->toArray();
		$base_data = $this->base_index();
		return view('Home.home',['article_lists'=>$articles]+$base_data);
	}

	public function search(Request $request)
	{
		$articles = Article::where('title','like','%'.$request->content.'%')
		->get()->toArray();
		$base_data = $this->base_index();
		return view('Home.home',['article_lists'=>$articles,'search'=>$request->content]+$base_data);
	}

}
