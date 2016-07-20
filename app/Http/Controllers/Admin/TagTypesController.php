<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\TagType;
use App\Models\Tag;

use App\Libs\Consts\Error;
use Redirect, Input, Auth;

class TagTypesController extends Controller {

	public function index()
	{
		return view('admin.tagtypes.index')->withTagtypes(TagType::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.tagtypes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|unique:tag_types|max:50',
			'remark' => 'required',
		]);

		$tagtype = new TagType;
		$tagtype->name = Input::get('name');
		$tagtype->remark = Input::get('remark');
		// $tagtype->user_id = 1;//Auth::user()->id;

		if ($tagtype->save()) {
			return Redirect::to('admin/tagtypes');
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
		return view('admin.tagtypes.edit')->withTagtype(TagType::find($id));
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
			'name' => 'required|unique:tag_types,name,'.$id.'|max:50',
			'remark' => 'required',
		]);
		$tagtype = TagType::find($id);
		$tagtype->name = Input::get('name');
		$tagtype->remark = Input::get('remark');
		// $tagtype->user_id = 1;//Auth::user()->id;

		if ($tagtype->save()) {
			return Redirect::to('admin/tagtypes');
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
		$tag_count = Tag::where('type',$id)->count();
		if (!empty($tag_count)) {
			return Redirect::withErrors(Error::EXIST_TAGS);
		}
		$tagtype = TagType::find($id);
		$tagtype->delete();

		return Redirect::to('admin/tagtypes');
	}

}
