<?php

namespace App\Notifications;

use App\Models\Courrier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentPosted extends Notification
{
    use Queueable;

    protected $user;
    protected $courrier;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param  Courrier  $courrier  Le courrier concerné.
     * @param  User  $user  L'utilisateur ayant posté le commentaire.
     */
    public function __construct(Courrier $courrier, User $user)
    {
        $this->courrier = $courrier;
        $this->user = $user;
    }

    /**
     * Détermine les canaux de notification (base de données uniquement).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Représentation de la notification dans la base de données.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'courrierTitle' => $this->courrier->objet,
            'courrierId'    => $this->courrier->id,
            'firstname'     => $this->user->firstname,
            'name'          => $this->user->name,
            'file'          => $this->courrier->file,
            'expediteur'    => $this->courrier->expediteur,
            'description'   => $this->courrier->description
        ];
    }

    /**
     * Représentation de la notification sous forme d'email (non utilisé ici).
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau commentaire sur un courrier')
            ->line('Un nouveau commentaire a été ajouté sur le courrier : ' . $this->courrier->objet)
            ->action('Voir le courrier', url('/courriers/' . $this->courrier->id))
            ->line('Merci d’utiliser notre application !');
    }
}
