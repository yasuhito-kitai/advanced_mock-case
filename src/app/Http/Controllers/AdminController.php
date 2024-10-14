<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\USer;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminEmail;
use App\Http\Requests\EmailRequest;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin_page');
    }

    public function admin_email_confirm(EmailRequest $request)
    {
        $receiver = $request->only('subject','body');
        $request->session()->put("form_input", $receiver);
        return view('email.admin_email_confirm', compact('receiver'));

    }

    public function admin_email_send(Request $request)
    {
        // 戻るボタンをクリックされた場合
        if ($request->input('back') == 'back') {

            return redirect('/admin-page')
            ->withInput();
        }
        $all_user = User::get(['name', 'email']);


        //メールフォームに入力した内容
        $subject = $request->subject;
        $body = $request->body;

        foreach ($all_user as $user) {
            $user_email = $user['email'];
            $user_name = $user['name'];
            Mail::to($user_email)->send(new AdminEmail($user_email, $user_name, $subject, $body));
        }
        $request->session()->forget('form_input');
        return redirect('/');
    }
    
}