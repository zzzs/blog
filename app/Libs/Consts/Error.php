<?php namespace App\Libs\Consts;
/**
*
*/
class Error
{
	/*公共*/
	CONST SAVE_ERROR   =  '保存失败！';
	CONST UPDATE_ERROR =  '更新失败！';
	CONST ADD_ERROR    =  '添加失败！';
	CONST DEL_ERROR    =  '删除失败！';
	CONST NOT_EXIST_RECODE = '不存在该记录！';

	/*标签类型*/
	CONST EXIST_TAGS = '该类型下存在标签不可删除！';

	/*下载图片*/
	CONST PIC_READ_ERROR = '读取文件错误';
	CONST PIC_SIZE_ERROR = '文件不能超过2M';
	CONST PIC_TYPE_ERROR = '文件类型错误';

	/*评论*/
	CONST COMMENT_PUBLISH_ERROR = '评论发表失败！';
	CONST COMMENT_PUBLISH_SUCCESS = '发表成功，待审核中...';
	CONST COMMENT_HAS_CHILD = '删除失败，请先删除回复发评论';

}
