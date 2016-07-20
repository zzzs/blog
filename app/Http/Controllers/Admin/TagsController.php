<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Tag;
use App\Models\TagType;

use Redirect, Input, Auth;

class TagsController extends Controller {

	public function index()
	{
		$tags = Tag::whereHas('TagType',function($q){
			$q->whereNotNull('id');
		})->with(['TagType'=>function($q){
			$q->select('id','name');
		}])->get();
		return view('admin.tags.index')->withTags($tags);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tagtypes = TagType::all();
		return view('admin.tags.create')->withTagtypes($tagtypes);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
			'type' => 'required',
		]);

		$tag = new Tag;
		$tag->type = Input::get('type');
		$tag->name = Input::get('name');
		$tag->extra = Input::get('more');
		// $tag->user_id = 1;//Auth::user()->id;

		if ($tag->save()) {
			return Redirect::to('admin/tags');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
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
		$tag = Tag::whereHas('TagType',function($q){
			$q->whereNotNull('id');
		})->with(['TagType'=>function($q){
			$q->select('id','name');
		}])->find($id);
		$tagtypes = TagType::all();
		return view('admin.tags.edit')->withTagtypes($tagtypes)->withTag($tag);
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
			'name' => 'required|max:255',
			'type' => 'required',
		]);
		$tag = Tag::find($id);
		$tag->type = Input::get('type');
		$tag->name = Input::get('name');
		$tag->extra = Input::get('more');
		// $tag->user_id = 1;//Auth::user()->id;

		if ($tag->save()) {
			return Redirect::to('admin/tags');
		} else {
			return Redirect::back()->withInput()->withErrors('保存失败！');
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
		$tag = Tag::find($id);
		$tag->delete();

		return Redirect::to('admin/tags');
	}

}
