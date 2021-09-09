<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function create(){
        return view('users.create');
    }

    /*
     * 用户信息展示
     */
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    /*
     * 用户注册
     */
    public function store(Request $request){
        $data = $request->all();
        $this->validate($request,[
            'name'     => 'required|unique:users|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('user.show',[$user]);
    }
}
