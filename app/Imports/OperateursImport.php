<?php
namespace App\Imports;

use App\Models\Operateur;
use App\Models\Operateurmodule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OperateursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Créer un utilisateur s'il n'existe pas déjà
        $user = User::firstOrCreate(
            ['email' => $row['email']], // Vérifier si l'utilisateur existe
            [
                'operateur'         => $row[''], //Nom operateur
                'username'          => $row[''], //Sigle
                'firstname'         => $row[''], //Sigle
                "fixe"              => $row[''],
                "telephone"         => $row[''],
                'email_responsable' => $row['email_responsable'],
                'password'          => Hash::make('password123'), // Générer un mot de passe par défaut
            ]);

        // 2. Insérer l'opérateur
        $operateur = Operateur::create([
            "numero_dossier"  => $row[''],
            'numero_arrive'   => $row[''],
            "numero_agrement" => $row[''],
            "type_demande"    => $row[''],
            "annee_agrement"  => $row[''],
            "statut_agrement" => $row[''],
            "departements_id" => $row[''],
            "regions_id"      => $row[''],
            'user_id'         => $user->id,
        ]);

        // 3. Associer les modules et autres colonnes
        if (! empty($row['modules'])) {
            $modules    = explode(',', $row['modules']);    // Exemple : "Module1,Module2,Module3"
            $domaines   = explode(',', $row['domaines']);   // Exemple : "Domaine1,Domaine2,Domaine3"
            $categories = explode(',', $row['categories']); // Exemple : "Cat1,Cat2,Cat3"
            $niveaux    = explode(',', $row['niveaux']);    // Exemple : "Niveau1,Niveau2,Niveau3"

            foreach ($modules as $index => $module) {
                OperateurModule::create([
                    'operateurs_id'        => $operateur->id,
                    "statut"               => $row['statut'], //agréer
                    'module'               => trim($module),
                    'domaine'              => $domaines[$index] ?? null, // Vérifie si l'index existe
                    'categorie'            => $categories[$index] ?? null,
                    'niveau_qualification' => $niveaux[$index] ?? null,
                ]);
            }
        }

        return $operateur;
    }
}
