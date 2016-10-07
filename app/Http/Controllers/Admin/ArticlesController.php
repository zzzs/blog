<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Recommend;
use App\Libs\Enums\TagType;
use App\Libs\Consts\Error;
use Michelf;

use Redirect, Input, Auth, DB;

class ArticlesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$cates = Tag::select('tag_id','name')
		->where('type',TagType::MAIN_MENU)
		->get();

		$articles = Article::withTrashed();
		if (($request->cate)) {
			$tag_id = $request->cate;
			$articles->whereHas('Tag',function($q)use($tag_id){
				$q->where('tag_id',$tag_id);
			});
		}

		if (!is_null($request->comstatus) && $request->comstatus != '') {
			$comstatus = $request->comstatus;
			$articles->whereHas('Comments',function($q)use($comstatus){
				$q->where('status',$comstatus);
			});
		}

		if (!empty($request->title)) {
			$articles->where('title','like','%'.$request->title.'%');
		}

		$articles = $articles->with([
			'Tag'=>function($q){
				$q->select('tag_id','name');
			},
			'Recommends'=>function($q){
				$q->select('articles.article_id');
			},
		])->paginate(15);

		return view('admin.articles.index',[
			'articles'=>$articles,
			'cates'=>$cates,
			'request'=>$request->all()
			]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cates = Tag::select('tag_id','name')
		->where('type',TagType::MAIN_MENU)
		->get();
		return view('admin.articles.create',['cates'=>$cates]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|unique:articles|max:100',
			'cate' => 'required',
			'body' => 'required',
		]);
		$article = new Article;
		$article->title = Input::get('title');
		$article->body = Input::get('body');
		$article->html_body = Michelf\MarkdownExtra::defaultTransform($article->body);
		$article->cate_id = Input::get('cate');
		$article->created_at = time();
		$article->updated_at = time();
		$article->user_id = 1;//Auth::user()->id;

		if ($article->save()) {
			return Redirect::to('admin/articles');
		} else {
			return Redirect::back()->withInput()->withErrors(Error::SAVE_ERROR);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cates = Tag::select('tag_id','name')
		->where('type',TagType::MAIN_MENU)
		->get();

		return view('admin.articles.edit',[
			'article'=>Article::find($id),
			'cates'=>$cates
			]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$this->validate($request, [
			'title' => 'required|unique:articles,title,'.$id.',article_id|max:50',
			'cate' => 'required',
			'body' => 'required',
		]);

		$article = Article::find($id);
		$article->title = Input::get('title');
		$article->cate_id = Input::get('cate');
		$article->body = Input::get('body');
		$article->html_body = Michelf\MarkdownExtra::defaultTransform($article->body);
		$article->updated_at = time();
		$article->user_id = 1;//Auth::user()->id;

		if ($article->save()) {
			return Redirect::to('admin/articles');
		} else {
			return Redirect::back()->withInput()->withErrors(Error::SAVE_ERROR);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);
		$article->delete();
		return Redirect::to('admin/articles');
	}

	/**
	 * 恢复
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function restore($id)
	{
		$article = Article::onlyTrashed()->find($id);
		$article->restore();
		return Redirect::to('admin/articles');
	}

	/**
	 * 查看评论
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function show_comments($id)
	{
		$article = Article::select('article_id','title','html_body')
		->with(['Comments'=>function($q){
			$q->where('status','<>',2)
				->with(['Guest'=>function($q){
                        $q->select('id', 'nickname', 'website');
                    }])
				->orderByRaw('pid,created_at');
		}])->find($id);

		return view('admin.articles.comments')->withArticle($article);
	}

	/**
	 * 查看推荐
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function show_recommends($id)
	{
		$article = Article::select('article_id','title','html_body','cate_id')
		->with('Recommends')->find($id);
		return view('admin.articles.recommends')->withArticle($article);
	}

	/**
	 * 未被推荐的文章
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function not_recommends(Request $request,$id)
	{
		$recom_art_ids = Recommend::where('article_id',$id)->lists('re_article_id');
		$recom_art_ids[] = $id;

		$articles = Article::whereNotIn('article_id',$recom_art_ids);
		if (($request->cate)) {
			$tag_id = $request->cate;
			$articles->whereHas('Tag',function($q)use($tag_id){
				$q->where('tag_id',$tag_id);
			});
		}

		if (!empty($request->title)) {
			$articles->where('title','like','%'.$request->title.'%');
		}

		$articles = $articles->get();

		return $this->jsonResponse($articles);
	}
}
