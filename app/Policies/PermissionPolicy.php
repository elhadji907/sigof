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
        // Vérifie si l'utilisateur a le rôle 'super-admin' (peu importe les autres rôles)
        return $user->hasRole('super-admin');
    }

    /**
     * Détermine si l'utilisateur peut supprimer une permission.
     */
    public function delete(User $user, Permission $permission): bool
    {
        // Vérifie si l'utilisateur a le rôle 'super-admin' (peu importe les autres rôles)
        return $user->hasRole('super-admin');
    }
}
