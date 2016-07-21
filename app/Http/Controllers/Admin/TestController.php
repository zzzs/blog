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
    public function sendEmailReminder(Request $request)
    {
        // $user = User::findOrFail($id);
// return 22;
        // Mail::send('emails.reminder', ['aaa' => 123], function ($m){
        //     $m->to($user->email, $user->name)->subject('Your Reminder!');
        // });
        Mail::raw('Text to e-mail', function ($m) {
            $m->to('863837949@qq.com', 'sa')->subject('Your Reminder!');
        });
    }
}
