<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\Status;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gravatar($size = '100'){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "https://img2.baidu.com/it/u=3355464299,584008140&fm=26&fmt=auto&gp=0.jpg";
    }

    /*
     * 在用户注册时生成激活令牌
     */
    public static function boot(){
        parent::boot();
        static::creating(function ($user){
           $user->activation_token = Str::random(10);
        });
    }

    //一对多
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    /*
     * 粉丝和用户 多对多  获取粉丝列表
     */
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    /*
     * 粉丝和用户 多对多 获取用户关注列表
     */
    public function followings(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    /*
     * 判断用户A是否关注了用户B
     */
    public function isFollowing($user_id){
        return $this->followings->cotains($user_id);
    }

    public function follow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids,false);
    }

    public function unfollow($user_ids){
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function feed(){
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids,$this->id);
        return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
    }
}
