<?php
namespace App\Console\Commands;

use App\Mail\BirthdayMail;
use App\Models\Commissionagrement;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendFinagrementEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-finagrement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un email aux opérateurs pour renouveler leur agrément';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*  $today = Carbon::today()->format('Y-m-d'); // On compare seulement mois et jour */
        $today = Carbon::today()->subYears(2)->format('Y-m-d'); //Récupérer les opérateurs dont la date agrement est il y a 2 ans
        /* dd($today); */
        $commissionagrements = Commissionagrement::get();

        foreach ($commissionagrements as $commissionagrement) {
            /* dd($commissionagrement->operateurs); */
            /* $commission = $commissionagrement::whereRaw("DATE_FORMAT(DATE_ADD(date, INTERVAL 2 DAY), '%Y-%m-%d') = ?", [$today])->get();
             */
            $commission = $commissionagrement::whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = ?", [$today])->get();
            dd($commission);

            Mail::to($operateur->email)->send(new BirthdayMail($operateur));
        }

        $this->info('Les e-mails d\'anniversaire ont été envoyés avec succès.');
    }
}
