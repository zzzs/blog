<?php
namespace App\Http\Controllers\Admin;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller{
    /**
     * 发送邮件给用户
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function send(Request $request)
    {
        $data = ['email'=>'15757857592@163.com', 'name'=>'lll'];
        Mail::send('emails.test', $data, function($message) use($data)
        {
            $message->to($data['email'], $data['name'])->subject('欢迎注册我们的网站，请激活您的账号！');
        });
    }
}
