<?php
/* namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class TrainingReminderNotification extends Notification
{
    use Queueable;

    protected $formation;
    protected $type;

    // Create a new notification instance.
     
    public function __construct($formation, $type)
    {
        $this->formation = $formation;
        $this->type      = $type; // "semaine" ou "veille"
    }

   // Get the notification's delivery channels.
    
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Get the mail representation of the notification.
     
    public function toMail($notifiable)
    {
        App::setLocale('fr');
        $subject = $this->type === 'semaine'
        ? '🚀 Votre formation commence dans une semaine !'
        : '⏳ Rappel : Votre formation commence demain !';

        $message = $this->type === 'semaine'
        ? "Nous vous rappelons que votre formation en **{$this->formation->module->name}** commence dans **une semaine**."
        : "📅 **Rappel** : Votre formation en **{$this->formation->module->name}** commence **demain**. Soyez prêt !"; */

        /* return (new MailMessage)
            ->subject($subject)
            ->greeting("Bonjour {$notifiable->firstname} {$notifiable->name} !")
            ->line($message)
            ->line("📍 **Lieu :** {$this->formation->lieu}")
            ->line("📅 **Dates :** du " . Carbon::parse($this->formation->date_debut)->format('d/m/Y') . " au " . Carbon::parse($this->formation->date_fin)->format('d/m/Y'))
            ->line("🎓 **Opérateur :** {$this->formation->operateur->user->operateur} ({$this->formation->operateur->user->username})")
            ->action('Voir les détails', url('sigof.onfp.sn'))
            ->line('Bonne formation et plein de succès ! 🚀')
            ->salutation(''); // ← Supprime le footer automatique */

/*         return (new MailMessage)
            ->subject($subject)
            ->greeting("Bonjour {$notifiable->firstname} {$notifiable->name} !")
            ->line($message)
            ->markdown('emails.training-reminder', [
                'formation'  => $this->formation,
                'notifiable' => $notifiable,
            ]);
    }
} */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class TrainingReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $formation;
    public $reminderType;

    public function __construct($formation, $reminderType)
    {
        $this->formation = $formation;
        $this->reminderType = $reminderType;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        App::setLocale('fr'); // S'assurer que l'email est en français

        return (new MailMessage)
            ->subject("📢 Rappel : Votre formation commence {$this->reminderType} !")
            ->view('emails.training-reminder', [
                'formation' => $this->formation,
                'notifiable' => $notifiable,
                'reminderType' => $this->reminderType
            ]);
    }
}
