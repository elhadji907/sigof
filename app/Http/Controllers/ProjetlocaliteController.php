<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Arrondissement;
use App\Models\Departement;
use App\Models\Region;
use App\Models\Projet;
use App\Models\Projetlocalite;
use App\Models\Individuelle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ProjetlocaliteController extends Controller
{
    public function showLocalites($id)
    {
        $projetlocalites = Projetlocalite::where('projets_id', $id)->get();
        $projet = Projet::findOrFail($id);

        return view('projetlocalites.index', compact('projetlocalites', 'projet'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'localite' => ["required", "string", Rule::unique('projetlocalites')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })],
            'effectif' => 'required|string',
        ]);

        $localite = $request?->type_localite;

        if (!empty($localite) && $localite == 'Commune') {
            $lieu = Commune::where('nom', $request->input("localite"))->first();
            if (!empty($lieu)) {
                $projetlocalite = new Projetlocalite([
                    "localite" => $request->input("localite"),
                    "effectif" => $request->input("effectif"),
                    'projets_id' => $request->input('projet'),
                ]);
                $projetlocalite->save();
                Alert::success('Féliciations ! ', 'localité ajoutée avec succès');
            } else {
                Alert::warning('Désolez ! ', $request->input("localite") . " n'est pas reconnu(e) comme " . $request?->type_localite);
            }
            return redirect()->back();
        }
        if (!empty($localite) && $localite == 'Arrondissement') {
            $lieu = Arrondissement::where('nom', $request->input("localite"))->first();
            if (!empty($lieu)) {
                $projetlocalite = new Projetlocalite([
                    "localite" => $request->input("localite"),
                    "effectif" => $request->input("effectif"),
                    'projets_id' => $request->input('projet'),
                ]);
                $projetlocalite->save();
                Alert::success('Féliciations ! ', 'localité ajoutée avec succès');
            } else {
                Alert::warning('Désolez ! ', $request->input("localite") . " n'est pas reconnu(e) comme " . $request?->type_localite);
            }
            return redirect()->back();
        }
        if (!empty($localite) && $localite == 'Departement') {
            $lieu = Departement::where('nom', $request->input("localite"))->first();
            if (!empty($lieu)) {
                $projetlocalite = new Projetlocalite([
                    "localite" => $request->input("localite"),
                    "effectif" => $request->input("effectif"),
                    'projets_id' => $request->input('projet'),
                ]);
                $projetlocalite->save();
                Alert::success('Féliciations ! ', 'localité ajoutée avec succès');
            } else {
                Alert::warning('Désolez ! ', $request->input("localite") . " n'est pas reconnu(e) comme " . $request?->type_localite);
            }
            return redirect()->back();
        }
        if (!empty($localite) && $localite == 'Region') {
            $lieu = Region::where('nom', $request->input("localite"))->first();
            if (!empty($lieu)) {
                $projetlocalite = new Projetlocalite([
                    "localite" => $request->input("localite"),
                    "effectif" => $request->input("effectif"),
                    'projets_id' => $request->input('projet'),
                ]);
                $projetlocalite->save();
                Alert::success('Féliciations ! ', 'localité ajoutée avec succès');
            } else {
                Alert::warning('Désolez ! ', $request->input("localite") . " n'est pas reconnu(e) comme " . $request?->type_localite);
            }
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'localite' => ["required", "string", Rule::unique('projetlocalites')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })->ignore($id)],
            'effectif' => 'required|string',
        ]);

        $projetlocalite = Projetlocalite::findOrFail($id);

        $projetlocalite->update([
            "localite" => $request->input("localite"),
            "effectif" => $request->input("effectif"),
            'projets_id' => $request->input('id'),
        ]);

        $projetlocalite->save();

        Alert::success('Féliciations ! ', 'localité modifiée avec succès');

        return redirect()->back();
    }
    public function show($id)
    {
        $projetlocalite = Projetlocalite::findOrFail($id);
        $projet = $projetlocalite?->projet;
        $type_localite = $projet->type_localite;

        $individuelles = Individuelle::join('modules', 'modules.id', 'individuelles.modules_id')
            ->select('individuelles.*')
            ->where('individuelles.projets_id', $projet?->id)
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

        return view('projetlocalites.individuelle',
            compact('individuelles',
                'projet',
                'commune',
                'arrondissement',
                'departement',
                'projetlocalite',
                'region'
            ));

    }
    public function destroy($id)
    {
        $projetlocalite = Projetlocalite::findOrFail($id);

        $projetlocalite->delete();

        Alert::success('Effectué ! ', 'localité supprimée avec succès');

        return redirect()->back();
    }
}
