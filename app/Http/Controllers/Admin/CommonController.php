<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Libs\Consts\Upload;
use App\Libs\Consts\Error;
use Maatwebsite\Excel\Facades\Excel;



class CommonController extends Controller {

	/**
	 * 加载本地MD文件
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function load_md_file(Request $request)
	{
		$data = '';
		$msg = '';
		$status = 0;
		if (($_FILES["file"]["size"] < 20000)){
			if ($_FILES["file"]["error"] > 0){
				$msg = Error::PIC_READ_ERROR;
			}else{
				$status = 1;
				$data = file_get_contents($_FILES["file"]["tmp_name"]);
			}
		}else{
			$msg = Error::PIC_SIZE_ERROR;
		}

		$this->json_return($data,$msg,$status);
	}

	/**
	 * 上传图片
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function upload_pic_link(Request $request)
	{
		$pic_type = Upload::UPLOAD_PIC_TYPE;
		$data = '';
		$msg = '';
		$status = 0;
		if ($_FILES["pic"]["size"] < 20000 && in_array($_FILES["pic"]["type"], $pic_type)){
			if ($_FILES["pic"]["error"] > 0){
				$msg = Error::PIC_READ_ERROR;
			}else{
				$status = 1;
				$save_url = Upload::ADMIN_PIC . date('Ymd').(time()/$_FILES["pic"]["size"]).$_FILES["pic"]["name"];

				move_uploaded_file($_FILES["pic"]["tmp_name"],public_path().$save_url);
				$server = $request->server();
				$data = $server['HTTP_ORIGIN'].$save_url;
			}
		}else{
			$msg = Error::PIC_SIZE_ERROR.'或'.Error::PIC_TYPE_ERROR;
		}

		$this->json_return($data,$msg,$status);
	}


	/**
	 * json返回
	 * @param  [type]  $data   [description]
	 * @param  string  $msg    [description]
	 * @param  integer $status [description]
	 * @return [type]          [description]
	 */
	public function json_return($data,$msg='',$status=0)
	{
		header('Content-Type:application/json; charset=utf-8');
		exit(json_encode([
			'status'=>$status,
			'msg'=>$msg,
			'data'=>$data]));
	}

}

