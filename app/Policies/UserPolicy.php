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
}
