<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{

    use HandlesAuthorization;

    /**
     * @param \app\Models\User  $user
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function viewAny(User $user){
        return $user->hasAnyRole(['super-admin']);    }


    /**
     *  @param \app\Models\User  $user
     * @return \Illumincate\Auth\Access\Response|bool
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin']);    }

    /**
     *  @param \app\Models\User  $user
     *  @param \Spatie\Permission\Models\Permission;
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function update(User $user, Permission $permission)
    {
        return $user->hasAnyRole(['super-admin']);    }

    /**
     *    *  @param \app\Models\User  $user
     *  @param \Spatie\Permission\Models\Permission;
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function delete(User $user, Permission $permission)
    {
        return $user->hasAnyRole(['super-admin']);    }


}
