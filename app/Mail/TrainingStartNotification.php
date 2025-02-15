<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingStartNotification extends Mailable
{
    use SerializesModels;

    public $individuelle;

    public function __construct($individuelle)
    {
        $this->individuelle = $individuelle;
    }

    public function build()
    {
        return $this->subject('Démarrage de votre formation')
                    ->view('emails.training_start_notification')
                    ->with([
                        'individuelle' => $this->individuelle,
                    ]);
    }
}
