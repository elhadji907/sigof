<?php
namespace App\Http\Controllers;

use App\Models\Emargement;
use App\Models\Feuillepresence;
use App\Models\Formation;
use App\Models\Individuelle;
use App\Models\Module;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class EmargementController extends Controller
{
    public function show(Request $request, $id)
    {
        $emargement = Emargement::findOrFail($id);

        return view('emargements.show', compact('emargement'));
    }

    public function giveindividuelleEmargement(Request $request, $id)
    {
        $individuelle = Feuillepresence::where('individuelles_id', $id)->where('emargements_id', $request->idemargement)->get();

        $individuelle->update([
            'presence' => $request->presence,

        ]);

        $emargement->save();

        Alert::success("Modification réussie", "La modification a été effectuée avec succès.");

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $emargement = Emargement::findOrFail($id);

        $this->validate($request, [
            'jour'    => "required|string",
            'feuille' => "nullable|file|mimes:pdf|max:2048",
            'date'    => 'nullable|date|min:10|max:10|date_format:Y-m-d',
        ]);

        if (! empty($request->input('date'))) {
            $date = $request->input('date');
        } else {
            $date = null;
        }

        if (request('feuille') && ! empty($emargement->file)) {
            Storage::disk('public')->delete($emargement->file);
            $filePath = request('feuille')->store('feuilles', 'public');
            $file     = $request->file('feuille');
            $emargement->update([
                'file' => $filePath,
            ]);

            $emargement->save();

        } elseif (request('feuille') && empty($emargement->file)) {
            $filePath = request('feuille')->store('feuilles', 'public');
            $file     = $request->file('feuille');
            $emargement->update([
                'file' => $filePath,
            ]);

            $emargement->save();
        }

        $emargement->update([
            'jour'         => $request->jour,
            'date'         => $date,
            'observations' => $request->observations,

        ]);

        $emargement->save();

        Alert::success("Modification réussie", "La modification a été effectuée avec succès.");

        return redirect()->back();
    }

    public function formationemargement(Request $request)
    {
        $formation  = Formation::findOrFail($request->input('idformation'));
        $module     = Module::findOrFail($request->input('idmodule'));
        $region     = Region::findOrFail($request->input('idlocalite'));
        $emargement = Emargement::findOrFail($request->input('idemargement'));

        if (! empty($formation?->projets_id)) {
            $individuelles = Individuelle::join('modules', 'modules.id', 'individuelles.modules_id')
                ->join('regions', 'regions.id', 'individuelles.regions_id')
                ->select('individuelles.*')
                ->where('individuelles.projets_id', $formation?->projets_id)
                ->where('individuelles.formations_id', $formation?->id)
                ->where('modules.name', 'LIKE', "%{$module->name}%")
                ->where('regions.nom', $region->nom)
            /* ->where('individuelles.statut', 'attente')
                ->orwhere('individuelles.statut', 'retirer')
                ->orwhere('individuelles.statut', 'retenu') */
                ->get();
        } else {
            $individuelles = Individuelle::join('modules', 'modules.id', 'individuelles.modules_id')
                ->join('regions', 'regions.id', 'individuelles.regions_id')
                ->select('individuelles.*')
                ->where('individuelles.formations_id', $formation?->id)
                ->where('modules.name', 'LIKE', "%{$module->name}%")
                ->where('regions.nom', $region->nom)
            /* ->where('individuelles.statut', 'attente')
                ->orwhere('individuelles.statut', 'retirer')
                ->orwhere('individuelles.statut', 'retenu') */
                ->get();
        }

        $candidatsretenus = Individuelle::where('formations_id', $formation?->id)
            ->get();

        $individuelleFormation = DB::table('individuelles')
            ->where('formations_id', $formation?->id)
            ->pluck('formations_id', 'formations_id')
            ->all();

        $individuelleFormationCheck = DB::table('individuelles')
            ->where('formations_id', '!=', null)
            ->where('formations_id', '!=', $formation?->id)
            ->pluck('formations_id', 'formations_id')
            ->all();

        return view(
            "emargements.show",
            compact(
                'emargement',
                'formation',
                'individuelles',
                'individuelleFormation',
                'module',
                'region',
                'candidatsretenus',
                'individuelleFormationCheck'
            )
        );
    }

    public function giveformationemargements(Request $request)
    {
        $request->validate([
            'individuelles' => ['required'],
        ]);

        $formation = Formation::findOrFail($idformation);

        if ($formation->statut == 'terminer') {
            Alert::warning('Désolé !', 'Cette formation a déjà été exécutée.');
        } elseif ($formation->statut == 'annuler') {
            Alert::warning('Désolé !', 'La formation a été annulée.');
        } else {
            foreach ($request->individuelles as $individuelle) {
                $individuelle = Individuelle::findOrFail($individuelle);
                $individuelle->update([
                    "formations_id" => $idformation,
                    "statut"        => 'retenu',
                ]);

                $individuelle->save();
            }

            $validated_by = new Validationindividuelle([
                'validated_id'     => Auth::user()->id,
                'action'           => 'retenu',
                'individuelles_id' => $individuelle->id,
            ]);

            $validated_by->save();

            Alert::success('Opération réussie !', 'Le(s) candidat(s) a/ont été ajouté(s) avec succès.');
        }

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
