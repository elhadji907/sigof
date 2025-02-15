<?php
namespace App\Console\Commands;

use App\Mail\TrainingStartNotification;
use App\Models\Formation;
use App\Models\Training; // Ajout de la modèle Training si nécessaire
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class NotifyTrainingStart extends Command
{
    /* protected $signature   = 'email:notify-training-start {formations_id}'; // Paramètre formations_id */
    protected $signature   = 'email:notify-training-start {formations_id}'; // Paramètre formations_id
    protected $description = 'Envoyer un e-mail aux demandeurs pour les informer du démarrage de la formation';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today()->addDays(5)->format('m-d'); // On compare seulement mois et jour
        // Récupérer l'ID de la formation à partir du paramètre
        $trainingId = $this->argument('formations_id');

        $formation = Formation::findOrFail($this->argument('formations_id'));

        $formation = $formation->whereRaw("DATE_FORMAT(date_debut, '%m-%d') = ?", [$today])->get();

     /*    if (! $formation) {
            $this->error("Aucune formation trouvée avec l'ID : " . $this->argument('formations_id'));
            return;
        } */
        foreach ($formation?->individuelles as $individuelle) {
            Mail::to($individuelle->user->email)->send(new TrainingStartNotification($individuelle));
        }

        $this->info('Les e-mails ont été envoyés aux demandeurs de formations pour la formation ID: ' . $trainingId);
    }
}
