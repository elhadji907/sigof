<?php
namespace App\Http\Controllers;

use App\Mail\ValidationDemandeIndividuelleNotification;
use App\Models\Individuelle;
use App\Models\Validationindividuelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class ValidationIndividuelleController extends Controller
{
    public function update($id)
    {
        $individuelle = Individuelle::findOrFail($id);

        foreach (Auth::user()->roles as $role) {
            if (! empty($role?->name) && ($role?->name != 'super-admin')) {
                if ($individuelle->statut == 'Attente') {
                    Alert::warning('Désolez !', 'demande déjà validée');
                } elseif ($individuelle->statut == 'programmer') {
                    Alert::warning('Désolez !', 'demande déjà programmée');
                } elseif ($individuelle->statut == 'Retenue') {
                    Alert::warning('Désolez !', 'demande déjà traitée');
                } elseif ($individuelle->statut == "Terminée") {
                    Alert::warning('Désolez !', 'demandeur déjà formé');
                } elseif ($individuelle->statut == 'Rejetée') {
                    Alert::warning('Désolez !', 'demandeur déjà rejetée');
                } else {
                    Alert::warning('Désolez !', 'action impossible');
                }
            } else {
                $individuelle->update([
                    'statut'       => 'Attente',
                    'validated_by' => Auth::user()->firstname . ' ' . Auth::user()->name,
                ]);

                $individuelle->save();

                $validated_by = new Validationindividuelle([
                    'validated_id'     => Auth::user()->id,
                    'action'           => 'Attente',
                    'individuelles_id' => $individuelle->id,
                ]);

                $validated_by->save();

                /* Envoie de mail */
                $toEmail     = $individuelle?->user?->email;
                $toUserName  = 'Félicitations ! ' . $individuelle?->user?->civilite . ' ' . $individuelle?->user?->firstname . ' ' . $individuelle?->user?->name;
                $safeMessage = "Votre demande de formation en <b><i>" . ($individuelle->module->name ?? 'cette formation') .
                    "</i></b> a été retenue. Vous pouvez désormais bénéficier de nos offres de formations.";
                $subject = 'Notification de validation !';
                $message = strip_tags($safeMessage, '<b><i><p>'); // Autorise seulement <b>, <i>, et <p>
                Mail::to($toEmail)->send(new ValidationDemandeIndividuelleNotification($message, $subject, $toEmail, $toUserName));

                /* Déplacer au niveau de ValidationDemandeIndividuelleNotification */
                /* Alert::success('Félicitation !', 'demande acceptée'); */
            }
        }
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            "motif" => "required|string",
        ]);

        $individuelle = Individuelle::findOrFail($id);

        if ($individuelle->statut == 'Rejetée') {
            Alert::warning('Désolez !', 'demande déjà rejetée');
        } elseif ($individuelle->statut == 'programmer') {
            Alert::warning('Désolez !', 'demande déjà programmée');
        } elseif ($individuelle->statut == 'Attente') {
            Alert::warning('Désolez !', 'demande déjà traitée');
        } elseif ($individuelle->statut == 'Retenue') {
            Alert::warning('Désolez !', 'demande déjà traitée');
        } elseif ($individuelle->statut == "Terminée") {
            Alert::warning('Désolez !', 'demandeur déjà formé');
        } else {
            $individuelle->update([
                'statut'      => 'Rejetée',
                'canceled_by' => Auth::user()->firstname . ' ' . Auth::user()->name,
            ]);

            $individuelle->save();

            $validated_by = new Validationindividuelle([
                'validated_id'     => Auth::user()->id,
                'action'           => 'Rejetée',
                'motif'            => $request->input('motif'),
                'individuelles_id' => $individuelle->id,
            ]);

            $validated_by->save();

            Alert::success('Fait ! ', 'demande rejetée');
        }

        return redirect()->back();
    }
}
