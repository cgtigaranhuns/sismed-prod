<?php

namespace App\Policies;

use App\Models\MedidaDisciplinar;
use Illuminate\Auth\Access\Response;
use App\Models\User;

class MedidaDisciplinarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View MedDiscipl');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MedidaDisciplinar $medidaDisciplinar)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create MedDiscipl');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MedidaDisciplinar $medidaDisciplinar): bool
    {
        return $user->hasPermissionTo('Edit MedDiscipl');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MedidaDisciplinar $medidaDisciplinar): bool
    {
        return $user->hasPermissionTo('Delete MedDiscipl');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MedidaDisciplinar $medidaDisciplinar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedidaDisciplinar $medidaDisciplinar)
    {
        //
    }
}
