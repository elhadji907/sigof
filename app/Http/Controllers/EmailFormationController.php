<?php
namespace App\Http\Controllers;

use App\Mail\WelcomeFormationEmail;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailFormationController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin']);
        /* $this->middleware(['permission:arrive-show']); */
        // or with specific guard
        /* $this->middleware(['role_or_permission:super-admin']); */
    }

    public function sendFormationEmail(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));
        foreach ($formation->individuelles as $individuelle) {
            $toEmail    = $individuelle?->user?->email;
            $Name       = '<b>Bonjour ' . $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name . ' </b>! ';
            $toUserName = strip_tags($Name, '<b><i><p><br>'); // Autorise seulement <b>, <i>, et <p>

            $message = $formation?->lieu . ', du ' . $formation?->date_debut?->format('d/m/Y') .
            ' au ' . $formation?->date_fin?->format('d/m/Y') . '. <br> <b>Opérateur</b> : '
            . $formation?->operateur?->user?->operateur .
            ' (<b><i>' . $formation?->operateur?->user?->username . '</b></i>)' . '. <br>Pour toute information complémentaire, vous pouvez contacter le formateur au '
            .
            substr($formation?->operateur?->user?->fixe, 0, 2) .
            ' ' .
            substr($formation?->operateur?->user?->fixe, 2, 3) .
            ' ' .
            substr($formation?->operateur?->user?->fixe, 5, 2) .
            ' ' .
            substr($formation?->operateur?->user?->fixe, 7, 2)
            ;
            $subject     = 'Notification démarrage formation !';
            $safeMessage = 'Vous avez été sélectionnée pour participer à la formation en <b><i>' . ($individuelle?->module?->name ?? 'cette formation') .
                '</i></b>. <br><b>Lieu</b> : ' . $message;
            $module = strip_tags($safeMessage, '<b><i><p><br>'); // Autorise seulement <b>, <i>, et <p>
            Mail::to($toEmail)->send(new WelcomeFormationEmail($message, $subject, $toEmail, $toUserName, $module));
        }
        return back();
    }

    public function sendFormationEmailCol(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));

        $toEmailUser        = $formation?->collectivemodule?->collective?->user?->email;
        $toEmailStructure   = $formation?->collectivemodule?->collective?->email;
        $toEmailResponsable = $formation?->collectivemodule?->collective?->email_responsable;

        $toUserName = 'Bonjour ! ' . $formation?->collectivemodule?->collective?->name . ' (' . $formation?->collectivemodule?->collective?->sigle . ').';

        $message = $formation?->lieu . ', ' . $formation?->departement?->nom . ', du ' . $formation?->date_debut?->format('d/m/Y') .
        ' au ' . $formation?->date_fin?->format('d/m/Y') . '. La formation sera assurée par l\'opérateur : ' . $formation?->operateur?->user?->operateur .
        '(' . $formation?->operateur?->user?->username . ')' . '. Pour toute information complémentaire, vous pouvez contacter le '
        . $formation?->operateur?->user?->telephone . '.';
        $subject          = 'Notification démarrage formation !';
        $collectivemodule = 'Votre formation en ' . $formation?->collectivemodule?->module . ' a été sélectionnée.'
            . 'Celle-ci se déroulera à ' . $message;
        Mail::to($toEmailUser)->send(new WelcomeFormationEmail($message, $subject, $toEmailUser, $toUserName, $collectivemodule));
        Mail::to($toEmailStructure)->send(new WelcomeFormationEmail($message, $subject, $toEmailStructure, $toUserName, $collectivemodule));
        Mail::to($toEmailResponsable)->send(new WelcomeFormationEmail($message, $subject, $toEmailResponsable, $toUserName, $collectivemodule));

        return back();

    }
}
