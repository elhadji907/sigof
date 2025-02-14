<?php
namespace App\Console\Commands;

use App\Models\Commissionagrement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyEndAgreements extends Command
{
    protected $signature   = 'email:notify-end-agreements';
    protected $description = 'Notifier les opérateurs dont l\'agrément a pris fin après 4 ans';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        /*  $today = Carbon::today()->format('Y-m-d'); // On compare seulement mois et jour */
        $today = Carbon::today()->subYears(4)->format('Y-m-d'); //Récupérer les opérateurs dont la date agrement est il y a 4 ans

        $commissionagrements = Commissionagrement::get();

        foreach ($commissionagrements as $commissionagrement) {
            $commission = $commissionagrement::whereRaw("DATE_FORMAT(date, '%Y-%m-%d') = ?", [$today])->first();
            if (! empty($commission)) {
                foreach ($commission?->operateurs as $key => $operateur) {
                    if (! empty($operateur) && $operateur->statut_agrement == 'expirer') {
                        $operateur->update(['statut_agrement' => 'fin']);
                        Mail::to($operateur?->user?->email)->send(new FinAgrementMail($operateur));
                    }
                }
            }
        }
        $this->info('E-mails envoyés aux opérateurs dont l\'agrément a pris fin après 4 ans.');
    }
}
