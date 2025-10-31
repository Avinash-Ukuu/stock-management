<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function admin(User $user)
    {
        return $user->hasRole("admin");
    }

    public function staff(User $user)
    {
        return $user->hasPermission("management","staff");
    }

    public function departmentHead(User $user)
    {
        return $user->hasPermission("management","departmentHead");
    }
}
