<?php

namespace App\Policies;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatResourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // TODO: admin user can do viewAny
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Cat $cat)
    {
        return $user->id === $cat->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // everyone can do create
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Cat $cat)
    {
        return $user->id === $cat->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Cat $cat)
    {
        return $user->id === $cat->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Cat $cat)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Cat $cat)
    {
        return false;
    }
}
