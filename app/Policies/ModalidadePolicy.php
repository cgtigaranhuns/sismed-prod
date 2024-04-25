<?php

namespace App\Policies;

use App\Models\Modalidade;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class ModalidadePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Modalidade');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Modalidade $modalidade)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Modalidade');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Modalidade $modalidade): bool
    {
        return $user->hasPermissionTo('Edit Modalidade');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Modalidade $modalidade): bool
    {
        return $user->hasPermissionTo('Delete Modalidade');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Modalidade $modalidade)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Modalidade $modalidade)
    {
        //
    }
}
