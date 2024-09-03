<?php

namespace App\Policies;

use App\Models\Penalidade;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class PenalidadePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Penalidade');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Penalidade $penalidade)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Penalidade');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Penalidade $penalidade): bool
    {
        return $user->hasPermissionTo('Edit Penalidade');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Penalidade $penalidade): bool
    {
        return $user->hasPermissionTo('Delete Modalidade');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Penalidade $penalidade)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Penalidade $penalidade)
    {
        //
    }
}
