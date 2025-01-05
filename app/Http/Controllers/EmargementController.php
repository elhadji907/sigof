<?php

namespace App\Http\Controllers;
use App\Models\Emargement;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Http\Request;

class EmargementController extends Controller
{
    public function show(Request $request, $id)
    {
        $emargement = Emargement::findOrFail($id);

        return view('emargements.show', compact('emargement'));
    }

    public function update(Request $request, $id)
    {
        $emargement = Emargement::findOrFail($id);

        $this->validate($request, [
            'jour' => "required|string",
            'date' => 'nullable|date|min:10|max:10|date_format:Y-m-d',
        ]);

        if (!empty($request->input('date'))) {
            $date = $request->input('date');
        } else {
            $date = null;
        }

        $emargement->update([
            'jour' => $request->jour,
            'date' => $date,
            'observations' => $request->observations,

        ]);

        $emargement->save();
        
        Alert::success("Modification réussie", "La modification a été effectuée avec succès.");

        return redirect()->back();
    }

    
    public function destroy($id)
    {
        $emargement = Emargement::find($id);
        $emargement->delete();

        Alert::success('Opération réussie !', 'La suppression a été effectuée avec succès.');

        return redirect()->back();
    }
}
