<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
     *  @param \Spatie\Permission\Models\Role  $role
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function update(User $user, Role $role)
    {
        return $user->hasAnyRole(['super-admin']);    }

    /**
     *    *  @param \app\Models\User  $user
     *  @param \Spatie\Permission\Models\Role  $role
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function delete(User $user, Role $role)
    {
return $user->hasAnyRole(['super-admin']);    }


}
