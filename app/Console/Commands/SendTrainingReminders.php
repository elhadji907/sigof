<?php
/* namespace App\Console\Commands;

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
} */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Formation;
use App\Notifications\TrainingReminderNotification;

class SendTrainingReminders extends Command
{
    protected $signature = 'email:send-training-reminders';
    protected $description = 'Envoyer des rappels de formation à une semaine, 3 jours et la veille';

    public function handle()
    {
        $today = Carbon::today();

        // Récupérer toutes les formations ayant lieu dans 7 jours, 3 jours et 1 jour
        $formations = Formation::whereIn('date_debut', [
            $today->copy()->addDays(7)->toDateString(),
            $today->copy()->addDays(3)->toDateString(),
            $today->copy()->addDays(1)->toDateString(),
        ])->get();

        foreach ($formations as $formation) {
            // Déterminer le type de rappel
            $daysRemaining = $today->diffInDays(Carbon::parse($formation->date_debut));

            $reminderType = match ($daysRemaining) {
                7 => 'dans une semaine',
                3 => 'dans trois jours',
                1 => 'demain',
                default => null,
            };

            if (!$reminderType) {
                continue;
            }

            // Parcourir tous les bénéficiaires de la formation
            foreach ($formation->individuelles as $individuelle) {
                $user = $individuelle->user;

                if ($user && $user->email) {
                    // Envoyer la notification
                    $user->notify(new TrainingReminderNotification($formation, $reminderType));
                }
            }
        }

        $this->info('Les rappels de formation ont été envoyés avec succès.');
    }
}
