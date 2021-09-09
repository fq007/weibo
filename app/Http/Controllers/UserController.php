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
//        $this->validate($request, [
//            'name' => 'required|unique:users|max:50',
//            'email' => 'required|email|unique:users|max:255',
//            'password' => 'required|confirmed|min:6'
//        ]);
//        return;
        dump($request);
        die;
        $this->validate($request,[
            'name'     => 'required|unique:user|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
