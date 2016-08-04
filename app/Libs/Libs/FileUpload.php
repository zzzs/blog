<?php namespace App\Libs\Libs;
/**
* 文件
*/
use Illuminate\Http\Request;
use App\Libs\Consts\Error;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Libs\Consts\Upload;

class FileUpload
{
	function __construct(Request $request)
	{
		$this->request = $request;
		$request_key = key($_FILES);
		if ($request->hasFile($request_key))
		{
			$this->error = Error::FILE_UPLOAD_ERROR;
			return false;
		}

		$file = $this->request->file($request_key);
		$this->file = $file;
	}

    private $file;

    private $request;

    private $error;

	/**
	 * 检验文件
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function checkFile()
	{
		$file = $this->file;
		if ($file->getError() !==0) {//error
			$this->error = Error::FILE_READ_ERROR;
			return false;
		}
		if ($file->getClientSize()  > 20000) {
			$this->error = Error::FILE_SIZE_ERROR;
			return false;
		}

		//图片
		$file_type = $file->getClientMimeType();
		if (false !== strpos($file_type, 'image')) {
			if (!in_array($file_type, Upload::UPLOAD_PIC_TYPE)) {
				$this->error = Error::FILE_TYPE_ERROR;
				return false;
			}
		}

		return true;
	}
	//error
	public function getError()
	{
		return $this->error;
	}

	/**
	 * 获取文件内容
	 * @return [type] [description]
	 */
	public function getFileContent()
	{
		return file_get_contents($this->file->getPathname());
	}

	/**
	 * 移动文件
	 * @param  string $dir  [description]
	 * @param  string $file [description]
	 * @return [type]       [description]
	 */
	public function moveFile($dir='',$file='')
	{
		$size = $this->file->getClientSize();
		$ext = $this->file->getClientOriginalExtension();
		$type = $this->file->getClientMimeType();
		if (empty($dir)) {
			if (false !== strpos($type, 'image')) {
				$dir = Upload::ADMIN_PIC;
			}else{
				$dir = Upload::ADMIN_FILE;
			}
		}
		$upload_dir = public_path().$dir;

		if (empty($file)) {
			$file = date('Ymd').(time()/$size).".".$ext;
		}

		try {
			$ret = $this->file->move($upload_dir,$file);
		} catch (FileException $e) {
			$this->error = Error::FILE_READ_ERROR;
			return false;
		}
		return $_SERVER['HTTP_ORIGIN'].$dir.$file;
	}

}
