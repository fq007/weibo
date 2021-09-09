<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
     * 用户更新个人资料授权策略验证
     */
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }

    /*
     * 设置只有管理员可以有删除其他用户的授权策略，并且管理员也不可以删除自己
     */
    public function destroy(User $currentUser,User $user){
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
