<?php
namespace App\Http\Controllers;

use App\Models\Feuillepresence;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FeuillepresenceController extends Controller
{
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'presence' => "required|string",
        ]);

        $feuillepresence = Feuillepresence::where('individuelles_id', $id)->where('emargements_id', $request->idemargement)->first();

        $feuillepresence->update([
            'presence' => $request->presence,

        ]);

        $feuillepresence->save();

        Alert::success("Modification réussie", "La modification a été effectuée avec succès.");

        return redirect()->back();
    }
}
