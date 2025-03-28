<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use RealRashid\SweetAlert\Facades\Alert;

class ImputationcourrierMail extends Mailable
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
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('mouhamadoulaminebara@onfp.sn', 'ONFP | Imputation courrier'),
            replyTo: [
                new Address('mouhamadoulaminebara@onfp.sn', 'ONFP | Réponse concernant le courrier'),
            ],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        Alert::success('Félicitations !', 'demande acceptée');
        return new Content(
            view: 'courriers.arrives.mailimputation',
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

    public function build()
    {
        return $this->view('courriers.arrives.mailimputation')
            ->attach(public_path('onfp.png'), [
                'as'   => 'logo.png',
                'mime' => 'image/png',
            ]);
    }
}
