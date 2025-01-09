<?php

namespace App\Http\Controllers;

use App\Models\Individuelle;
use App\Models\Projetmodule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ProjetmoduleController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'module' => ["required", "string", Rule::unique('projetmodules')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'domaine' => 'required|string',
            'effectif' => 'required|string',
        ]);

        $projetmodule = new Projetmodule([
            "module" => $request->input("module"),
            "domaine" => $request->input("domaine"),
            "effectif" => $request->input("effectif"),
            'projets_id' => $request->input('projet'),
        ]);

        $projetmodule->save();

        Alert::success('Féliciations ! ', 'module ajouté avec succès');

        return redirect()->back();
    }

    public function show($id)
    {
        $projetmodule = Projetmodule::findOrFail($id);
        $projet = $projetmodule?->projet;
        $type_localite = $projet->type_localite;

        $individuelles = Individuelle::join('modules', 'modules.id', 'individuelles.modules_id')
            ->select('individuelles.*')
            ->where('individuelles.projets_id', $projetmodule?->projet?->id)
            ->where('modules.name', $projetmodule?->module)
            ->get();

        if ($type_localite == 'Region') {
            $region = 'Région';
            $departement = null;
            $arrondissement = null;
            $commune = null;
        } elseif ($type_localite == 'Departement') {
            $departement = 'Département';
            $arrondissement = null;
            $commune = null;
            $region = null;
        } elseif ($type_localite == 'Arrondissement') {
            $arrondissement = 'Arrondissement';
            $commune = null;
            $departement = null;
            $region = null;
        } elseif ($type_localite == 'Commune') {
            $commune = 'Commune';
            $departement = null;
            $region = null;
            $arrondissement = null;
        } else {
            $commune = null;
            $departement = null;
            $region = null;
            $arrondissement = null;
        }

        return view('projets.module-individuelle',
            compact('individuelles',
                'projet',
                'commune',
                'arrondissement',
                'departement',
                'projetmodule',
                'region'
            ));

    }

    public function update(Request $request, $id)
    {
        $projetmodule = Projetmodule::findOrFail($id);

        $this->validate($request, [
            'module' => 'required|string',
            'domaine' => 'required|string',
            'effectif' => 'required|string',
        ]);

        $projetmodule->update([
            "module" => $request->input("module"),
            "domaine" => $request->input("domaine"),
            "effectif" => $request->input("effectif"),
        ]);

        $projetmodule->save();

        Alert::success('Effectué ! ', 'module modifié avec succès');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $projetmodule = Projetmodule::find($id);
        $projetmodule->delete();

        Alert::success('Effectué', 'supprimé avec succès');
        return redirect()->back();
    }
}
