<?php
namespace App\Http\Controllers;

use App\Models\Feuillepresencecollective;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FeuillepresencecollectiveController extends Controller
{
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'presence' => "required|string",
        ]);

        $feuillepresence = Feuillepresencecollective::where('emargementcollectives_id', $request->idemargement)
            ->where('listecollectives_id', $id)
            ->first();

        /*  if (! empty($request->presence) && $request->presence == 'Présent' && $individuelle?->user?->civilite == 'Mme') {
        $presence = 'Présente';
    } elseif (! empty($request->presence) && $request->presence == 'Absent' && $individuelle?->user?->civilite == 'Mme') {
        $presence = 'Absente';
    } else {
        $presence = $request->presence;
    } */

        $feuillepresence->update([
            'presence' => $request->presence,

        ]);

        $feuillepresence->save();

        Alert::success("Modification réussie", "La modification a été effectuée avec succès.");

        return redirect()->back();
    }
}
