<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);
        $this->middleware('guest',[
           'only' => ['create']
        ]);
    }

    /*
     * 用户列表
     */
    public function index(){
        $users = User::paginate(6);
        return view('users.index',compact('users'));
    }

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
    
    /*
     * 用户编辑操作
     */
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /*
     * 更新个人资料
     */
    public function update(User $user,Request $request){
        $this->authorize('update',$user);
        $this->validate($request,[
            'name'     => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','个人资料更新成功');
        return redirect()->route('user.show',$user->id);
    }

    /*
     * 删除用户操作
     */
    public function destroy(User $user){
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户');
        return back();
    }
}
