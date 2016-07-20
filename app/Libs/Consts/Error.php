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

	/*标签类型*/
	CONST EXIST_TAGS = '该类型下存在标签不可删除！';

	/*下载图片*/
	CONST PIC_READ_ERROR = '读取文件错误';
	CONST PIC_SIZE_ERROR = '文件不能超过2M';
	CONST PIC_TYPE_ERROR = '文件类型错误';

}
