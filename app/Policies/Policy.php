<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    protected $permissions;
    protected $notification;
    
    public function validate(User $user, $alias)
    {
        $this->permissions = $user->getPermissionsList($user);

        if (in_array($alias, $this->permissions)) {
            return true;
        }

        return false;
    }
}
