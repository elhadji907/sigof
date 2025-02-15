<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formation;
    public $notifiable;

    /**
     * Create a new message instance.
     */
    public function __construct($formation, $notifiable)
    {
        $this->formation = $formation;
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Rappel de Formation')
                    ->view('emails.training-reminder');
    }
}
