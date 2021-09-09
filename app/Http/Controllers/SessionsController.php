<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create(){
        return view('sessions.create');
    }

    /*
     * 登录
     */
    public function store(Request $request){
        $email = $request->name;
        $password = $request->password;
        $result = $this->validate($request,[
           'email'     => 'required|email|max:255',
            'password' => 'required'
        ]);
        if(Auth::attempt($result)){
            session()->flash('success','欢迎回来');
            return redirect()->route('user.show',[Auth::user()]);
        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    /*
     * 登出
     */
    public function destroy(){
        Auth::logout();
        session()->flash('success','您已成功推出！');
        return redirect('login');
    }
}
