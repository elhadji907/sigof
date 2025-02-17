<?php

namespace App\Http\Controllers;

use App\Models\Collective;
use App\Models\Validationcollective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ValidationcollectiveController extends Controller
{
    public function update($id)
    {
        $collective   = Collective::findOrFail($id);
        if ($collective->statut_demande == 'Attente') {
            Alert::warning('Désolez !', 'demande déjà validée');
        } elseif ($collective->statut_demande == 'Retenue') {
            Alert::warning('Désolez !', 'demande déjà retenue');
        } else {
            $collective->update([
                'statut_demande'             => 'Attente',
                'validated_by'       =>  Auth::user()->firstname . ' ' . Auth::user()->name,
            ]);

            $collective->save();

            $validated_by = new Validationcollective([
                'validated_id'       =>       Auth::user()->id,
                'action'             =>      'Attente',
                'collectives_id'   =>      $collective->id
            ]);

            $validated_by->save();

            Alert::success('Félicitation !', 'demande acceptée');
        }

        /* return redirect()->back()->with("status", "Demande validée"); */
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            "motif" => "required|string",
        ]);

        $collective   = Collective::findOrFail($id);

        if ($collective->statut_demande == 'Rejetée') {
            Alert::warning('Désolez !', 'demande déjà rejetée');
        }  elseif ($collective->statut_demande == 'Retenue') {
            Alert::warning('Désolez !', 'demande déjà retenue');
        } else {
            $collective->update([
                'statut_demande'                => 'Rejetée',
                'canceled_by'           =>  Auth::user()->firstname . ' ' . Auth::user()->name,
            ]);

            $collective->save();

            $validated_by = new Validationcollective([
                'validated_id'       =>      Auth::user()->id,
                'action'             =>      'Rejetée',
                'motif'              =>      $request->input('motif'),
                'collectives_id'   =>      $collective->id
            ]);

            $validated_by->save();

            Alert::success('Fait ! ', 'demande rejetée');
        }

        return redirect()->back();
    }
}
