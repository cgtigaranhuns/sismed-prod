<?php

namespace App\Policies;

use App\Models\Turno;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class TurnoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Turno');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Turno $turno)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Turno');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Turno $turno): bool
    {
        return $user->hasPermissionTo('Edit Turno');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Turno $turno): bool
    {
        return $user->hasPermissionTo('Delete Turno');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Turno $turno)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Turno $turno)
    {
        //
    }
}
