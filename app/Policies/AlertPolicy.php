<?php

namespace App\Policies;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
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
        if ($user->email !== config('transittracker.admin_email')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Alert $alert)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->email !== config('transittracker.admin_email')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Alert $alert)
    {
        if ($user->email !== config('transittracker.admin_email')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Alert $alert)
    {
        if ($user->email !== config('transittracker.admin_email')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Alert $alert)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Alert $alert)
    {
        //
    }
}
