<?php namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Libs\Enums\TagType;
class BaseController extends Controller
{
	public function base_index($where=[])
	{
		//主菜单
		$main_menus = Tag::whereHas('TagType',function($q){
			$q->whereNotNull('id');
		})->where('type',TagType::MAIN_MENU)
		->get()
		->toArray();
		//标签
		$tags = Tag::whereHas('TagType',function($q){
			$q->whereNotNull('id');
		})->where('type','<>',TagType::MAIN_MENU)
		->where('type','<>',TagType::LOVE_LINK)
		->lists('name','type');
		//友情链接
		$love_links = Tag::whereHas('TagType',function($q){
			$q->whereNotNull('id');
		})->where('type',TagType::LOVE_LINK)
		->get()
		->toArray();
		//搜索
		$search = (isset($where[0]) && $where[0]=='title')?str_replace('%', '', $where[2]):'';
		return [
			'website'=>$tags[TagType::WEBSITE],
			'motto'=>$tags[TagType::MOTTO],
			'home_page'=>$tags[TagType::HOME_PAGE],
			'love_links'=>$love_links,
			'main_menus'=>$main_menus
			];
	}

}
