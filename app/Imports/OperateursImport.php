<?php
namespace App\Imports;

use App\Models\Operateur;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OperateursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        DB::transaction(function () use ($row) {
            // 1. Insérer ou récupérer l'utilisateur (évite les doublons)
            $user = User::firstOrCreate(
                ['email' => $row['email']], // Vérifier si l'utilisateur existe
                [
                    'operateur'         => $row['operateur'],
                    'username'          => $row['username'],
                    'firstname'         => $row['firstname'],
                    "fixe"              => $row['fixe'],
                    "telephone"         => $row['telephone'],
                    'email_responsable' => $row['email_responsable'],
                    'password'          => Hash::make('password123'), // Mot de passe par défaut sécurisé
                ]
            );

            // 2. Insérer ou mettre à jour l'opérateur (évite les doublons)
            $operateur = Operateur::updateOrCreate(
                ['numero_dossier' => $row['numero_dossier']], // Vérifie l'existence d'un opérateur
                [
                    'numero_arrive'   => $row['numero_arrive'],
                    "numero_agrement" => $row['numero_agrement'],
                    "type_demande"    => $row['type_demande'],
                    "annee_agrement"  => $row['annee_agrement'],
                    "statut_agrement" => $row['statut_agrement'],
                    'users_id'        => $user->id,
                ]
            );

            // 3. Associer les modules et autres colonnes
            /* if (! empty($row['modules'])) {
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
            } */

            return $operateur;
        });
    }
}
