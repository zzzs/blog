<?php namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Http\Controllers\Home\BaseController;

class ArticlesController extends BaseController {

  public function show($id)
  {
  	$base_data = $this->base_index();
    return view('home.articles.show',['article'=>Article::with('Comments')->find($id)]+$base_data);
  }

}
