<?php
namespace App\Console\Commands;

use App\Models\Formation;
use App\Models\User;
use App\Notifications\TrainingReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTrainingReminders extends Command
{
    protected $signature   = 'email:send-training-reminders';
    protected $description = 'Envoie des rappels aux bénéficiaires des formations (une semaine avant et la veille)';

    public function handle()
    {
        $today        = Carbon::today();
        $oneWeekLater = $today->copy()->addWeek();
        $oneDayLater  = $today->copy()->addDay();

        // Formations qui commencent dans une semaine
        $formationsInAWeek = Formation::whereDate('date_debut', $oneWeekLater)->get();
        foreach ($formationsInAWeek as $formation) {
            $this->sendEmails($formation, 'semaine');
        }

        // Formations qui commencent demain
        $formationsTomorrow = Formation::whereDate('date_debut', $oneDayLater)->get();
        foreach ($formationsTomorrow as $formation) {
            $this->sendEmails($formation, 'veille');
        }

        $this->info("Les emails de rappel ont été envoyés avec succès !");
    }

    private function sendEmails($formation, $type)
    {
        foreach ($formation->individuelles as $individuelle) {
            if ($individuelle->user) { // Vérifie que l'utilisateur existe
                $individuelle->user->notify(new TrainingReminderNotification($formation, $type));
            }
        }
    }
}
