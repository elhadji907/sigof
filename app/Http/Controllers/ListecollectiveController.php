<?php
namespace App\Http\Controllers;

use App\Models\Listecollective;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ListecollectiveController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware('auth');
        $this->middleware(['role:super-admin|admin|Demandeur|DIOF']);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'cin'            => [
                'required',
                'string',
                'min:16',
                'max:17',
                Rule::unique(Listecollective::class)->whereNull('deleted_at'),
            ],
            "civilite"       => "required|string",
            "firstname"      => "required|string",
            "name"           => "required|string",
            'date_naissance' => ['nullable', 'date_format:d/m/Y'],
            "lieu_naissance" => "required|string",
            "module"         => "required|string",
            "niveau_etude"   => "nullable|string",
            "telephone"      => "nullable|string|min:9|max:12",
        ]);

        $dateString     = $request->input('date_naissance');
        $date_naissance = Carbon::createFromFormat('d/m/Y', $dateString);

        $membre = Listecollective::create([
            'cin'                  => $request->input('cin'),
            'civilite'             => $request->input('civilite'),
            'prenom'               => format_proper_name($request->input('firstname')),
            'nom'                  => remove_accents_uppercase($request->input('name')),
            'date_naissance'       => $date_naissance,
            'lieu_naissance'       => remove_accents_uppercase($request->input('lieu_naissance')),
            'niveau_etude'         => $request->input('niveau_etude'),
            'telephone'            => $request->input('telephone'),
            'experience'           => $request->input('experience'),
            'autre_experience'     => $request->input('autre_experience'),
            'details'              => $request->input('details'),
            'statut'               => 'nouveau',
            'collectivemodules_id' => $request->input('module'),
            'collectives_id'       => $request->input('collective'),
        ]);

        $membre->save();

        Alert::success('Succès !', 'enregistrement effectué avec succès.');

        return redirect()->back();
    }

    public function edit($id)
    {
        foreach (Auth::user()->roles as $key => $role) {
        }
        $listecollective = Listecollective::find($id);
        if ($listecollective->statut != 'nouveau' && ! empty($role?->name) && ($role?->name != 'super-admin')) {
            Alert::warning('Désolé !', 'Impossible de modifier ce demandeur.');
            return redirect()->back();
        } else {
            return view("collectives.updateliste", compact("listecollective"));
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cin'                       => [
                'required',
                'string',
                'min:16',
                'max:17',
                Rule::unique(Listecollective::class)->ignore($id)->whereNull('deleted_at'),
            ],
            "civilite"       => "required|string",
            "firstname"      => "required|string",
            "name"           => "required|string",
            'date_naissance' => ['nullable', 'date_format:d/m/Y'],
            "lieu_naissance" => "required|string",
            "module"         => "required|string",
            "niveau_etude"   => "nullable|string",
            "telephone"      => "nullable|string|min:9|max:12",
        ]);

        $listecollective = Listecollective::find($id);
        $dateString     = $request->input('date_naissance');
        $date_naissance = Carbon::createFromFormat('d/m/Y', $dateString);

        $listecollective->update([
            'cin'                  => $request->input('cin'),
            'civilite'             => $request->input('civilite'),
            'prenom'               => format_proper_name($request->input('firstname')),
            'nom'                  => remove_accents_uppercase($request->input('name')),
            'date_naissance'       => $date_naissance,
            'lieu_naissance'       => remove_accents_uppercase($request->input('lieu_naissance')),
            'niveau_etude'         => $request->input('niveau_etude'),
            'telephone'            => $request->input('telephone'),
            'experience'           => $request->input('experience'),
            'autre_experience'     => $request->input('autre_experience'),
            'details'              => $request->input('details'),
            'collectivemodules_id' => $request->input('module'),
            'collectives_id'       => $request->input('collective'),
        ]);

        $listecollective->save();

        Alert::success("Modification réussie !", "Merci.");

        return Redirect::route('collectivemodules.show', $request->input('module'));
    }

    public function show($id)
    {
        $listecollective = Listecollective::find($id);
        return view("collectives.showlistecollective", compact("listecollective"));
    }

    public function destroy($id)
    {
        $listecollective = Listecollective::find($id);

        if (! empty($listecollective->formations_id)) {
            Alert::warning('Désolé !', 'Action impossible.');
            return redirect()->back();
        } else {
            $listecollective->delete();
            Alert::success('Supprimé !', 'Le demandeur a été supprimé avec succès.');
            return redirect()->back();
        }
    }

    public function Validatelistecollective($id)
    {
        $listecollective = Listecollective::findOrFail($id);

        $listecollective->update([
            'statut' => 'Attente',
        ]);
        $listecollective->save();
        Alert::success('Bravo !', 'La demande a été validée.');
        return redirect()->back();
    }
}
