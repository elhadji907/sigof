<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgreementEndEmail extends Mailable
{
    use SerializesModels;

    public $operateur;

    public function __construct($operateur)
    {
        $this->operateur = $operateur;
    }

    public function build()
    {
        return $this->subject("Votre agrément a pris fin, {$this->operateur?->user?->username} !")
                    ->view('emails.agreement_end')
                    ->with([
                        'name' => $this->operateur,
                    ]);
    }
}
