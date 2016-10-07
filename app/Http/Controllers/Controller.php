<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function jsonResponse($data='', $message='成功', $status=0, $headers = [])
	{
		header('Content-Type: application/json; charset=utf-8');

		echo json_encode([
			'status' =>$status,
			'msg' => $message,
			'data' => $data
			]);
		exit;

		return response()->json([
			'status' =>$status,
			'msg' => $message,
			'data' => $data
			]);
	}

}
