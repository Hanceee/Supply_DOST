<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;


class ActivityPolicy
{

    use HandlesAuthorization;

    /**
     *
     * @param \app\Models\User  $user
     * @return \Illumincate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin']);

    }



    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin']);

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, user $model)
    {
        return $user->hasAnyRole(['super-admin']);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, user $model)
    {
        return $user->hasAnyRole(['super-admin']);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, user $model)
    {
        return $user->hasAnyRole(['super-admin']);

    }


}
