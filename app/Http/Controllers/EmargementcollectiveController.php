<?php
namespace App\Http\Controllers;

use App\Models\Emargementcollective;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EmargementcollectiveController extends Controller
{

    public function formationemargementcollective(Request $request)
    {
        $formation            = Formation::findOrFail($request->input('idformation'));
        $emargementcollective = Emargementcollective::findOrFail($request->input('idemargement'));

        $collectiveFormation = DB::table('listecollectives')
            ->where('formations_id', $formation?->id)
            ->pluck('formations_id', 'formations_id')
            ->all();

        $collectiveFormationCheck = DB::table('listecollectives')
            ->where('formations_id', '!=', null)
            ->where('formations_id', '!=', $formation?->id)
            ->pluck('formations_id', 'formations_id')
            ->all();

        $feuillepresenceListecollective = DB::table('feuillepresencecollectives')
            ->where('emargementcollectives_id', $emargementcollective?->id)
            ->pluck('emargementcollectives_id', 'emargementcollectives_id')
            ->all();

        return view(
            "emargementcollectives.show",
            compact(
                'emargementcollective',
                'formation',
                'feuillepresenceListecollective',
            )
        );
    }

    public function destroy($id)
    {
        $emargementcollective = Emargementcollective::findOrFail($id);

        $feuillesPresenceCollectives = $emargementcollective->feuillesPresenceCollectives;

        foreach ($feuillesPresenceCollectives as $key => $feuillesPresenceCollective) {
            $feuillesPresenceCollective->delete();
        }

        /* $feuillepresenceListecollective = $emargementcollective->feui */

        $emargementcollective->delete();

        Alert::success('Bravo', 'Suppression effectuée avec succès');

        return redirect()->back();
    }
}
