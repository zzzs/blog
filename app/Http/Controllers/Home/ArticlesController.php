<?php namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Http\Controllers\Home\BaseController;

class ArticlesController extends BaseController {

  public function show($id)
  {
  	$base_data = $this->base_index();
  	$article = Article::with([
  		'Comments'=>function($q){
  			$q->where('status','=',1)->orderByRaw('pid,created_at');
  		}])->find($id);
    return view('home.articles.show',['article'=>$article]+$base_data);
  }

}
