<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Détermine si l'utilisateur peut modifier un rôle.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer un rôle.
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole('super-admin');
    }
}
