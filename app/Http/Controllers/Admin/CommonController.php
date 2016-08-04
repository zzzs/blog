<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Libs\Consts\Error;
use Maatwebsite\Excel\Facades\Excel;
use Michelf;
use App\Libs\Libs\FileUpload;

class CommonController extends Controller {

	/**
	 * 加载本地MD文件
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function load_md_file(Request $request)
	{
		$FileUpload = new FileUpload($request);

		if ($FileUpload->checkFile() === true ) {
			$this->jsonResponse($FileUpload->getFileContent(),'ok',0);
		}else{
			$this->jsonResponse('',$FileUpload->getError(),1);
		}
	}

	/**
	 * 上传图片
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function upload_pic_link(Request $request)
	{
		$FileUpload = new FileUpload($request);
		if ($FileUpload->checkFile() === true) {
			$piclink = $FileUpload->moveFile();
			if ($piclink != false) {
				$this->jsonResponse($piclink,'ok',0);
			}
		}
		$this->jsonResponse('',$FileUpload->getError(),1);
	}

	/**
	 * MD预览
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function preview(Request $request)
	{
		$html_body = Michelf\MarkdownExtra::defaultTransform($request->art_body);
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode(['html_body'=>$html_body]));
	}

}

