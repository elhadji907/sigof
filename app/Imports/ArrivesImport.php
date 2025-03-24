<?php
namespace App\Imports;

use App\Models\Arrive;
use App\Models\Courrier;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArrivesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Si la valeur est un nombre d'Excel (c'est-à-dire un nombre de jours depuis 1900)
        if (is_numeric($row['date_recep'])) {
            // Convertir le nombre en une date réelle avec Carbon
            $dateRecep = Carbon::createFromFormat('Y-m-d', Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_recep'] - 2)->format('Y-m-d'))->toDateTimeString();
        } else {
            // Si la date est déjà un format valide, utilise-la telle quelle
            $dateRecep = $row['date_recep'];
        }
        // Si la valeur est un nombre d'Excel (c'est-à-dire un nombre de jours depuis 1900)
        if (is_numeric($row['date_cores'])) {
            // Convertir le nombre en une date réelle avec Carbon
            $dateCores = Carbon::createFromFormat('Y-m-d', Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_cores'] - 2)->format('Y-m-d'))->toDateTimeString();
        } else {
            // Si la date est déjà un format valide, utilise-la telle quelle
            $dateCores = $row['date_cores'];
        }
        // Si la valeur est un nombre d'Excel (c'est-à-dire un nombre de jours depuis 1900)
        if (is_numeric($row['date_reponse'])) {
            // Convertir le nombre en une date réelle avec Carbon
            $dateReponse = Carbon::createFromFormat('Y-m-d', Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['date_reponse'] - 2)->format('Y-m-d'))->toDateTimeString();
        } else {
            // Si la date est déjà un format valide, utilise-la telle quelle
            $dateReponse = $row['date_reponse'];
        }

        /*     $courrier = Courrier::firstOrCreate(
            ['numero_courrier' => $row['numero_courrier']],
            [
                'date_recep'     => $dateRecep,
                'date_cores'     => $dateCores,
                'date_reponse'   => $dateReponse,
                'annee'          => $row['annee'],
                'objet'          => $row['objet'],
                'expediteur'     => $row['expediteur'],
                'reference'      => $row['reference'],
                'numero_reponse' => $row['numero_reponse'],
                'observation'    => $row['observation'],
                'type'           => $row['type'],
                'user_create_id' => $row['user_create_id'],
                'user_update_id' => $row['user_update_id'],
                'users_id'       => $row['users_id'],
            ]
        );

        return new Arrive([
            'courriers_id'  => $courrier->id,
            'numero_arrive' => $row['numero_arrive'],
        ]); */

        $courrier = Courrier::firstOrCreate(
            ['numero_courrier' => $row['numero_courrier']],
            [
                'date_recep'     => $dateRecep,
                'date_cores'     => $dateCores,
                'date_reponse'   => $dateReponse,
                'annee'          => $row['annee'],
                'objet'          => $row['objet'],
                'expediteur'     => $row['expediteur'],
                'reference'      => $row['reference'],
                'numero_reponse' => $row['numero_reponse'],
                'observation'    => $row['observation'],
                'type'           => $row['type'],
                'user_create_id' => $row['user_create_id'],
                'user_update_id' => $row['user_update_id'],
                'users_id'       => $row['users_id'],
            ]
        );

        // Vérifier si le numéro d'arrivée existe déjà
        $arrive = Arrive::where('numero_arrive', $row['numero_arrive'])->first();
        if (! $arrive) {
            $arrive = Arrive::create([
                'courriers_id'  => $courrier->id,
                'numero_arrive' => $row['numero_arrive'],
            ]);
        }

        return $arrive;
    }
}
