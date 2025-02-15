<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FinAgrementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $operateur;

    public function __construct($operateur)
    {
        $this->operateur = $operateur;
    }

    public function build()
    {
        return $this->subject("Renouvellement de votre agrément, {$this->operateur?->user?->username} !")
                    ->view('emails.finagrement')
                    ->with('operateur', $this->operateur);
    }
}
