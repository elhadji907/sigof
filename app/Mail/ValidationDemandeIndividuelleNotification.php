<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use RealRashid\SweetAlert\Facades\Alert;

class ValidationDemandeIndividuelleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $subject;
    public $toEmail;
    public $toUserName;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $subject, $toEmail, $toUserName)
    {
        $this->mailMessage = $message;
        $this->subject     = $subject;
        $this->toEmail     = $toEmail;
        $this->toUserName  = $toUserName;
    }

    /**
     * Get the message envelope.
     */
/*     public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validation Demande Individuelle Notification',
        );
    } */

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('lamine.badji@onfp.sn', 'ONFP | Validation demande de formation'),
            replyTo: [
                new Address('lamine.badji@onfp.sn', 'ONFP | Réponse concernant votre nouvelle demande de formation'),
            ],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
/*     public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    } */

    public function content(): Content
    {
        /* Alert::success("E-mail envoyés !", "La notification de validation été envoyée avec succès."); */
        Alert::success('Félicitations !', 'demande acceptée');
        return new Content(
            view: 'individuelles.mailinfo',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
