<?php

namespace App\Policies;

use App\Models\ServerEmail;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{

    use HandlesAuthorization;

    /**
     * @param \app\Models\ServerEmail  $user
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function viewAny(ServerEmail $user){
        return $user->hasAnyRole(['super-admin']);    }


    /**
     *  @param \app\Models\ServerEmail  $user
     * @return \Illumincate\Auth\Access\Response|bool
     * Determine whether the user can create models.
     */
    public function create(ServerEmail $user)
    {
        return $user->hasAnyRole(['super-admin']);    }

    /**
     *  @param \app\Models\ServerEmail  $user
     *  @param \Spatie\Permission\Models\Permission;
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function update(ServerEmail $user, Permission $permission)
    {
        return $user->hasAnyRole(['super-admin']);    }

    /**
     *    *  @param \app\Models\ServerEmail  $user
     *  @param \Spatie\Permission\Models\Permission;
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function delete(ServerEmail $user, Permission $permission)
    {
        return $user->hasAnyRole(['super-admin']);    }


}
