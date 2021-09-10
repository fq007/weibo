<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);

        // 限流 10 分钟十次
        $this->middleware('throttle:10,10', [
            'only' => ['store']
        ]);
    }

    public function create(){
        return view('sessions.create');
    }

    /*
     * 登录
     */
    public function store(Request $request){
        $result = $this->validate($request,[
           'email'     => 'required|email|max:255',
            'password' => 'required'
        ]);
        if(Auth::attempt($result,$request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success','欢迎回来');
                $fallback = route('user.show', Auth::user());
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
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
