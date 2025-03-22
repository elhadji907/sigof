<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * Détermine si l'utilisateur peut modifier une permission.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer une permission.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasRole('super-admin');
    }
}
