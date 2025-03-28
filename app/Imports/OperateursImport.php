<?php
namespace App\Imports;

use App\Models\Operateur;
use App\Models\Operateurmodule;
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
                    'adresse'           => $row['adresse'],
                    'email_responsable' => $row['email_responsable'],
                    'password'          => Hash::make('password123'), // Mot de passe par défaut sécurisé
                ]
            );

            // Assigner un rôle à l'utilisateur (si présent dans le fichier Excel)
            $user->assignRole('Operateur');

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
            if (! empty($row['modules'])) {
                $modules    = explode(';', $row['modules']);
                $domaines   = explode(';', $row['domaines']);
                $categories = explode(';', $row['categories']);
                $niveaux    = explode(';', $row['niveaux']);

                foreach ($modules as $index => $module) {
                    Operateurmodule::create([
                        'operateurs_id'        => $operateur->id,
                        "statut"               => $row['statut'], // agréer
                        'module'               => trim($module),
                        'domaine'              => $domaines[$index] ?? null, // Vérifie si l'index existe
                        'categorie'            => $categories[$index] ?? null,
                        'niveau_qualification' => 'Qualification',
                    ]);
                }
            }

            return $operateur;
        });
    }
}
