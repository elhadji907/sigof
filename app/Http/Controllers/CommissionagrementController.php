<?php
namespace App\Http\Controllers;

use App\Models\Commissionagrement;
use App\Models\Commissionmembre;
use App\Models\Historiqueagrement;
use App\Models\Operateur;
use App\Models\Operateurmodule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CommissionagrementController extends Controller
{
    public function index()
    {
        $commissionagrements = Commissionagrement::get();

        return view('operateurs.commissionagrements.index', compact('commissionagrements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commission'    => 'required|string|unique:commissionagrements,commission,except,id',
            "date_agrement" => "nullable|date|max:10|min:10|date_format:Y-m-d",
            'session'       => 'required|string',
            'annee'         => 'required|string',
            'description'   => 'nullable|string',
            'lieu'          => 'nullable|string',

        ]);

        if (! empty($request->input('date_agrement'))) {
            $date_agrement = $request->input('date_agrement');
        } else {
            $date_agrement = null;
        }

        $commissionagrement = new Commissionagrement([

            'commission'  => $request->input('commission'),
            'session'     => $request->input('session'),
            'description' => $request->input('description'),
            'lieu'        => $request->input('lieu'),
            'annee'       => $request->input('annee'),
            'date'        => $date_agrement,

        ]);

        $commissionagrement->save();
        Alert::success('Effectuée !', 'Commission ajoutée avec succès');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $request->validate([
            'commission'    => ["required", "string", "unique:commissionagrements,commission,{$id}"],
            'session'       => 'required|string',
            'date_agrement' => "nullable|date|min:10|max:10|date_format:Y-m-d",
            'lieu'          => 'nullable|string',
            'annee'         => 'required|string',

        ]);

        if (! empty($request->input('date_agrement'))) {
            $date_agrement = $request->input('date_agrement');
        } else {
            $date_agrement = null;
        }

        $commissionagrement->update([
            'commission'  => $request->input('commission'),
            'session'     => $request->input('session'),
            'description' => $request->input('description'),
            'lieu'        => $request->input('lieu'),
            'annee'       => $request->input('annee'),
            'date'        => $date_agrement,

        ]);

        $commissionagrement->save();

        Alert::success('Effectuée !', 'Commission modifiée avec succès');

        return redirect()->back();
    }

    public function show($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $operateurs = Operateur::where('commissionagrements_id', $id)
            ->where('statut_agrement', '!=', 'non retenu')
            ->get();

        $operateur_count = $operateurs->count();

        if (! empty($operateur_count) && $operateur_count > 50) {
            $decoupage = ($operateur_count / 50);
        } else {
            $decoupage = null;
        }

        $operateurs_agreer_count = Operateur::where('commissionagrements_id', $id)
            ->where('statut_agrement', 'agréer')
            ->count();

        $operateurs_reserve_count = Operateur::where('commissionagrements_id', $id)
            ->where('statut_agrement', 'sous réserve')
            ->count();

        $operateurs_rejeter_count = Operateur::where('commissionagrements_id', $id)
            ->where('statut_agrement', 'Rejetée')
            ->count();

        /*  $operateurAgrement = DB::table('operateurs')
        ->where('commissionagrements_id', $commissionagrement->id)
        ->pluck('id', 'id')
        ->all();

        $operateurAgrementCheck = DB::table('operateurs')
        ->where('commissionagrements_id', '!=', null)
        ->where('commissionagrements_id', '!=', $id)
        ->pluck('id', 'id')
        ->all(); */
        
        return view('operateurs.commissionagrements.show',
            compact('commissionagrement',
                'operateurs',
                'decoupage',
                'operateurs_agreer_count',
                'operateurs_reserve_count',
                'operateurs_rejeter_count'
            ));
    }

    public function destroy($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        if (! empty($commissionagrement?->operateurs)) {
            Alert::warning('Attention !', 'Impossible de supprimer cette commission');
        } else {
            $commissionagrement->delete();
            Alert::success('Effectuée !', 'Commission supprimée avec succès');
        }
        return redirect()->back();
    }

    public function givecommisionagrement(Request $request, $idcommissionagrement)
    {
        $request->validate([
            'operateurs' => ['required'],
        ]);

        $operateur_deja_retenus = Operateur::where('commissionagrements_id', $idcommissionagrement)->get();

        /*   foreach ($operateur_deja_retenus as $key => $value) {

        $value->update([
        "commissionagrements_id"        =>  null,
        ]);

        $value->save();
        } */

        foreach ($request->operateurs as $operateur) {
            $operateur = Operateur::findOrFail($operateur);

            $operateur->update([
                "commissionagrements_id" => $idcommissionagrement,
                "statut_agrement"        => 'Attente',
            ]);

            $operateur->save();

            $historiqueagrement = new Historiqueagrement([
                'operateurs_id'          => $operateur->id,
                'commissionagrements_id' => $idcommissionagrement,
                'statut'                 => 'Attente',
                'validated_id'           => Auth::user()->id,

            ]);

            $historiqueagrement->save();
        }

        Alert::success('Félicitations !', 'opérateur(s) ajouté(s) avec succès');

        return redirect()->back();
    }

    public function addopCommission($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $operateurs = Operateur::where('statut_agrement', 'Retenu')
            ->orwhere('statut_agrement', 'Attente')
            ->orwhere('statut_agrement', 'Retiré')
            ->get();

        $operateurAgrement = DB::table('operateurs')
            ->where('commissionagrements_id', $commissionagrement->id)
            ->pluck('id', 'id')
            ->all();

        $operateurAgrementCheck = DB::table('operateurs')
            ->where('commissionagrements_id', '!=', null)
            ->where('commissionagrements_id', '!=', $id)
            ->pluck('id', 'id')
            ->all();

        return view('operateurs.commissionagrements.add_op_commsions',
            compact('commissionagrement',
                'operateurs',
                'operateurAgrement',
                'operateurAgrementCheck'));
    }

    public function showAgreer($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $operateurs = Operateur::where('commissionagrements_id', $commissionagrement->id)
            ->where('statut_agrement', 'agréer')
            ->get();

        $operateurmodules = Operateurmodule::join('operateurs', 'operateurs.id', 'operateurmodules.operateurs_id')
            ->select('operateurmodules.*')
            ->where('operateurs.statut_agrement', "agréer")
            ->where('operateurs.commissionagrements_id', $commissionagrement->id)
            ->where('operateurmodules.statut', "agréer")
            ->get();

        $count_operateurmodules_distinct = Operateurmodule::join('operateurs', 'operateurs.id', 'operateurmodules.operateurs_id')
            ->select('operateurmodules.*')
            ->where('operateurs.statut_agrement', "agréer")
            ->where('operateurs.commissionagrements_id', $commissionagrement->id)
            ->where('operateurmodules.statut', "agréer")
            ->distinct('module')
            ->count('module');

        return view('operateurs.agrements.show_agreer',
            compact('operateurs',
                'commissionagrement',
                'operateurmodules',
                'count_operateurmodules_distinct'
            ));
    }

    public function showReserve($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $operateurs = Operateur::where('commissionagrements_id', $commissionagrement->id)
            ->where('statut_agrement', 'sous réserve')
            ->get();

        $operateurmodules = Operateurmodule::join('operateurs', 'operateurs.id', 'operateurmodules.operateurs_id')
            ->select('operateurmodules.*')
            ->where('operateurs.statut_agrement', "sous réserve")
            ->where('operateurs.commissionagrements_id', $commissionagrement->id)
            ->where('operateurmodules.statut', "sous réserve")
            ->get();

        return view('operateurs.agrements.show_reserve',
            compact('operateurs',
                'commissionagrement',
                'operateurmodules'));
    }

    public function showRejeter($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $operateurs = Operateur::where('commissionagrements_id', $commissionagrement->id)
            ->where('statut_agrement', 'Rejetée')
            ->get();

        return view('operateurs.agrements.show_rejeter',
            compact('operateurs',
                'commissionagrement'));
    }

    public function jury($id)
    {
        $commissionagrement = Commissionagrement::findOrFail($id);

        $membres = Commissionmembre::get();

        $membreJury = $commissionagrement->commissionmembres->pluck('id', 'id')->all();

        return view('operateurs.commissionagrements.add_membres_commsions',
            compact('commissionagrement', 'membres', 'membreJury'));
    }

    public function addMembreJury(Request $request, $id)
    {
        $request->validate([
            'membres' => ['required'],

        ]);

        $commissionagrement = Commissionagrement::findOrFail($id);
        
        $commissionagrement->commissionmembres()->sync($request->membres);

        Alert::success('Bravo !', 'Membres ajoutés avec succès');

        return redirect()->back();
    }
}
