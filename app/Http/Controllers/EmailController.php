<?php
namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
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

    public function sendWelcomeEmail(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));
        foreach ($formation->individuelles as $individuelle) {
            $toEmail    = $individuelle?->user?->email;
            $module     = $formation?->module?->name;
            $toUserName = 'Félicitations ! ' . $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name;
            $message    = 'Votre formation en ' . $module . ' est maintenant terminée, vous avez obtenue la note de ' . $individuelle?->note_obtenue . '/20, avec la mention ' . $individuelle?->appreciation . '.';
            $subject    = 'Notification de fin de formation ! ';
            Mail::to($toEmail)->send(new WelcomeEmail($message, $subject, $toEmail, $toUserName, $module));
        }
        return back();
    }

    public function sendWelcomeEmailCol(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));

        $toEmailUser        = $formation?->collectivemodule?->collective?->user?->email;
        $toEmailStructure   = $formation?->collectivemodule?->collective?->email;
        $toEmailResponsable = $formation?->collectivemodule?->collective?->email_responsable;
        $collectivemodule   = $formation?->collectivemodule?->module;

        $toUserName = 'Félicitations ! ' . $formation?->collectivemodule?->collective?->name . ' (' . $formation?->collectivemodule?->collective?->sigle . ').';
        $message    = 'Votre formation en ' . $collectivemodule . ' est maintenant terminée.';
        $subject    = 'Notification de fin de formation ! ';
        Mail::to($toEmailUser)->send(new WelcomeEmail($message, $subject, $toEmailUser, $toUserName, $collectivemodule));
        Mail::to($toEmailStructure)->send(new WelcomeEmail($message, $subject, $toEmailStructure, $toUserName, $collectivemodule));
        Mail::to($toEmailResponsable)->send(new WelcomeEmail($message, $subject, $toEmailResponsable, $toUserName, $collectivemodule));

        return back();
    }
}
