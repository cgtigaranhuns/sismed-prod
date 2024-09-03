<?php

namespace App\Policies;

use App\Models\Periodo;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class PeriodoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Periodo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Periodo $periodo)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Periodo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Periodo $periodo): bool
    {
        return $user->hasPermissionTo('Edit Periodo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Periodo $periodo): bool
    {
        return $user->hasPermissionTo('Delete Periodo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Periodo $periodo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Periodo $periodo)
    {
        //
    }
}
