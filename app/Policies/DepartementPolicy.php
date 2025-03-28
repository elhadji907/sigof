<?php

namespace App\Policies;

use App\Models\Departement;
use App\Models\User;

class DepartementPolicy
{
    /**
     * Définir les rôles autorisés.
     */
    private function hasAccess(User $user)
    {
        return $user->hasRole(['super-admin', 'admin']); // Vérifie si l'utilisateur a l'un des rôles
    }

    public function view(User $user, Departement $departement)
    {
        return $this->hasAccess($user);
    }

    public function update(User $user, Departement $departement)
    {
        return $this->hasAccess($user);
    }

    public function delete(User $user, Departement $departement)
    {
        return $this->hasAccess($user);
    }

    public function show(User $user, Departement $departement)
    {
        return $this->hasAccess($user);
    }
}

