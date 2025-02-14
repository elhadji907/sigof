<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\BirthdayMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie un email aux utilisateurs le jour de leur anniversaire';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->format('m-d'); // On compare seulement mois et jour

        $users = User::whereRaw("DATE_FORMAT(date_naissance, '%m-%d') = ?", [$today])->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new BirthdayMail($user));
        }

        $this->info('Les e-mails d\'anniversaire ont été envoyés avec succès.');
    }
}
