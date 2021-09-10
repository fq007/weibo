<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function test(){
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //获取去除掉ID为1的用户的所有用户
        $followers = DB::table('users')->where('id','>',1)->get();
//        $followers = $user1->slice(1);

        $followers_ids = $followers->pluck('id')->toArray();
        $user1 = new User();
        //关注除了 1 号用户以外的所有用户
        $user1->follow($followers_ids);
        dump(1111);
        die;
        //除了1号用户  所有用户都来关注1号用户
        foreach ($followers as $follower){
            $follower->follow($user_id);
        }
    }
}
