<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ServerEmailPolicy
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



}
