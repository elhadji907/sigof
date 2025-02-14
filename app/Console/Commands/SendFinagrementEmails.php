<?php
namespace App\Console\Commands;

use App\Models\Commissionagrement;
use Carbon\Carbon;
use App\Mail\FinAgrementMail;
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
        /* $today = Carbon::today()->format('Y-m-d'); */
        /* dd($today); */
        $datefinagrementdefinitive = Carbon::today()->subYears(4)->format('Y-m-d'); //après 4 ans, le faut faire une nouvelle demande

        $commissionagrements = Commissionagrement::get();

        foreach ($commissionagrements as $commissionagrement) {
            /* dd($commissionagrement->operateurs); */
            /* $commission = $commissionagrement::whereRaw("DATE_FORMAT(DATE_ADD(date, INTERVAL 2 DAY), '%Y-%m-%d') = ?", [$today])->get();
             */
            $commission = $commissionagrement::whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = ?", [$today])->first();
            /* $commission = $commissionagrement::whereRaw("DATE_FORMAT(DATE_ADD(date, INTERVAL 1 DAY), '%Y-%m-%d') = ?", [$today])->first(); */

            /* dd($commission->operateurs); */

            foreach ($commission?->operateurs as $key => $operateur) {
                if (! empty($operateur) && $operateur->statut_agrement == 'agréer') {
                    $operateur->update(['statut_agrement' => 'expirer']);
                    Mail::to($operateur?->user?->email)->send(new FinAgrementMail($operateur));
                }
            }

        }
        $this->info('Les e-mails de fin d\'agrement des opérateurs ont été envoyés avec succès.');
    }
}
